<?php
/**
 * Customer Receipt Page
 * Shows a printable receipt for paid orders
 */

include 'admin/config/dbcon.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    header('Location: login.php?error=Please login to view receipts');
    exit();
}

$user_id = $_SESSION['auth_user']['id'];

// Get token from URL
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token)) {
    header('Location: orders.php?message=Invalid order token&message_type=error');
    exit();
}

// Get order details
$stmt = $conn->prepare("SELECT c.*, pt.reference as payment_reference, pt.amount as payment_amount, pt.created_at as payment_date, pt.gateway_response, pt.payment_method FROM checkout c LEFT JOIN paystack_transactions pt ON c.id = pt.order_id WHERE c.token = ? AND c.user_id = ?");
$stmt->bind_param("si", $token, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

// Check if order exists and belongs to user
if (!$order) {
    header('Location: orders.php?message=Order not found or access denied&message_type=error');
    exit();
}

// Check if order is paid
if (($order['status'] ?? '') !== 'paid') {
    header('Location: order-details.php?token=' . urlencode($token) . '&message=Receipt is only available for paid orders&message_type=warning');
    exit();
}

// Get order items
$stmt = $conn->prepare("SELECT c.*, pi.image_path FROM cart c LEFT JOIN product_images pi ON c.product_id = pi.product_id AND pi.is_primary = 1 WHERE c.checkout_token = ? AND c.cart_status = 'processed'");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$order_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get user details
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $result->fetch_assoc();
$stmt->close();

// Ensure user data is safe
$user = $user ?: [];
$user_first_name = trim($user['first_name'] ?? '');
$user_last_name = trim($user['last_name'] ?? '');
$user_email = trim($user['email'] ?? '');
$user_phone = trim($user['phone'] ?? '');

// Generate receipt number
$receipt_number = 'RCP-' . date('Ymd') . '-' . str_pad($order['id'], 6, '0', STR_PAD_LEFT);

// Function to get payment method display name
function getPaymentMethodDisplayName($paymentMethod) {
    switch (strtolower($paymentMethod)) {
        case 'mpesa':
        case 'mobile_money':
            return 'M-Pesa Mobile Money';
        case 'card':
        case 'credit_card':
        case 'debit_card':
            return 'Credit/Debit Card';
        case 'bank':
        case 'bank_transfer':
            return 'Bank Transfer';
        case 'ussd':
            return 'USSD Payment';
        case 'unknown':
            return 'Unknown Payment Method';
        default:
            return ucfirst($paymentMethod);
    }
}

// Function to extract payment method from Paystack response
function getPaymentMethod($gatewayResponse) {
    if (!$gatewayResponse) return 'Unknown';
    
    $response = json_decode($gatewayResponse, true);
    if (!$response) return 'Unknown';
    
    // Method 1: Check for channel = mobile_money (most reliable for M-Pesa STK)
    if (isset($response['data']['channel'])) {
        $channel = strtolower($response['data']['channel']);
        if ($channel === 'mobile_money') {
            return 'M-Pesa Mobile Money';
        }
    }
    
    // Method 2: Check for authorization channel = mobile_money
    if (isset($response['data']['authorization']['channel'])) {
        $channel = strtolower($response['data']['authorization']['channel']);
        if ($channel === 'mobile_money') {
            return 'M-Pesa Mobile Money';
        }
    }
    
    // Method 3: Check for bank = M-PESA
    if (isset($response['data']['authorization']['bank'])) {
        $bank = strtolower($response['data']['authorization']['bank']);
        if ($bank === 'm-pesa' || $bank === 'mpesa') {
            return 'M-Pesa Mobile Money';
        }
    }
    
    // Method 4: Check for brand = M-pesa
    if (isset($response['data']['authorization']['brand'])) {
        $brand = strtolower($response['data']['authorization']['brand']);
        if ($brand === 'm-pesa' || $brand === 'mpesa') {
            return 'M-Pesa Mobile Money';
        }
    }
    
    // Method 5: Check for mobile_money_number (specific to mobile money)
    if (isset($response['data']['authorization']['mobile_money_number'])) {
        return 'M-Pesa Mobile Money';
    }
    
    // Method 6: Check for mobile_money_provider
    if (isset($response['data']['authorization']['mobile_money_provider'])) {
        $provider = strtolower($response['data']['authorization']['mobile_money_provider']);
        if ($provider === 'mpesa') {
            return 'M-Pesa Mobile Money';
        }
    }
    
    // Method 7: Check for authorization_code pattern (M-Pesa codes start with QK, QL, etc.)
    if (isset($response['data']['authorization']['authorization_code'])) {
        $authCode = $response['data']['authorization']['authorization_code'];
        if (preg_match('/^Q[KL]/', $authCode)) {
            return 'M-Pesa Mobile Money';
        }
    }
    
    // Method 8: Check for country_code (Kenya) and no card info
    if (isset($response['data']['authorization']['country_code'])) {
        $countryCode = strtolower($response['data']['authorization']['country_code']);
        if ($countryCode === 'ke') {
            // If it's Kenya and no card info, likely M-Pesa
            if (!isset($response['data']['authorization']['card_type']) && 
                !isset($response['data']['authorization']['last4'])) {
                return 'M-Pesa Mobile Money';
            }
        }
    }
    
    // Method 9: Check for account_name (M-Pesa shows phone number)
    if (isset($response['data']['authorization']['account_name'])) {
        $accountName = $response['data']['authorization']['account_name'];
        if (preg_match('/^\d{10,12}$/', $accountName)) {
            return 'M-Pesa Mobile Money';
        }
    }
    
    // Method 10: Check for gateway_response text
    if (isset($response['data']['authorization']['gateway_response'])) {
        $gatewayResponse = strtolower($response['data']['authorization']['gateway_response']);
        if (strpos($gatewayResponse, 'mpesa') !== false || 
            strpos($gatewayResponse, 'mobile money') !== false) {
            return 'M-Pesa Mobile Money';
        }
    }
    
    // Check for domain in the response
    if (isset($response['data']['domain'])) {
        $domain = strtolower($response['data']['domain']);
        switch ($domain) {
            case 'card':
                return 'Credit/Debit Card';
            case 'mobile_money':
                return 'M-Pesa Mobile Money';
            case 'bank':
                return 'Bank Transfer';
            case 'ussd':
                return 'USSD Payment';
            default:
                return ucfirst($domain);
        }
    }
    
    // Check for payment_type in the response
    if (isset($response['data']['payment_type'])) {
        $paymentType = strtolower($response['data']['payment_type']);
        switch ($paymentType) {
            case 'card':
                return 'Credit/Debit Card';
            case 'mobile_money':
                return 'M-Pesa Mobile Money';
            case 'bank':
                return 'Bank Transfer';
            default:
                return ucfirst($paymentType);
        }
    }
    
    // Check for gateway_response in the response (nested response)
    if (isset($response['data']['gateway_response'])) {
        $gatewayResponse = strtolower($response['data']['gateway_response']);
        if (strpos($gatewayResponse, 'mpesa') !== false) {
            return 'M-Pesa Mobile Money';
        } elseif (strpos($gatewayResponse, 'card') !== false) {
            return 'Credit/Debit Card';
        } elseif (strpos($gatewayResponse, 'bank') !== false) {
            return 'Bank Transfer';
        }
    }
    
    return 'Paystack Payment';
}

// Function to get payment method icon
function getPaymentMethodIcon($paymentMethod) {
    $method = strtolower($paymentMethod);
    if (strpos($method, 'card') !== false) {
        return 'fas fa-credit-card';
    } elseif (strpos($method, 'mpesa') !== false || strpos($method, 'mobile') !== false) {
        return 'fas fa-mobile-alt';
    } elseif (strpos($method, 'bank') !== false) {
        return 'fas fa-university';
    } elseif (strpos($method, 'ussd') !== false) {
        return 'fas fa-phone';
    } else {
        return 'fas fa-money-bill-wave';
    }
}

// Function to get M-Pesa code from response
function getMpesaCode($gatewayResponse) {
    if (!$gatewayResponse) return null;
    
    $response = json_decode($gatewayResponse, true);
    if (!$response) return null;
    
    // Check various possible locations for M-Pesa code
    if (isset($response['data']['authorization']['authorization_code'])) {
        return $response['data']['authorization']['authorization_code'];
    }
    
    if (isset($response['data']['reference'])) {
        return $response['data']['reference'];
    }
    
    if (isset($response['data']['access_code'])) {
        return $response['data']['access_code'];
    }
    
    return null;
}

// Get payment method - first try database column, then fallback to parsing gateway_response
$payment_method = '';
if (!empty($order['payment_method']) && $order['payment_method'] !== 'unknown') {
    $payment_method = getPaymentMethodDisplayName($order['payment_method']);
} else {
    $payment_method = getPaymentMethod($order['gateway_response'] ?? '');
}

$payment_method_icon = getPaymentMethodIcon($payment_method);
$mpesa_code = getMpesaCode($order['gateway_response'] ?? '');

// Format dates
$order_date = date('d-M-Y H:i', strtotime($order['created_at'] ?? 'now'));
$payment_date = date('d-M-Y', strtotime($order['payment_date'] ?? $order['created_at'] ?? 'now'));
$due_date = date('d-M-Y', strtotime($order['payment_date'] ?? $order['created_at'] ?? 'now'));
$printed_date = date('m/d/Y H:i:s');

// Calculate totals
$subtotal = floatval($order['cart_subtotal'] ?? 0);
$discount = floatval($order['discount'] ?? 0);
$shipping = floatval($order['shipping_cost'] ?? 0);
$total = floatval($order['total_amount'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Order #<?= htmlspecialchars($order['shipment_number'] ?? 'N/A') ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style type="text/css">
  .PageBreak { page-break-before: always }
  div[class^="s"] { line-height:1.15em }
  div.wb { word-wrap:break-word }
  .s27 { font-family:Verdana;font-size:10px;width:176px;min-height:16px;overflow:visible; }
  .s11 { text-align:center;font-family:Arial;font-size:8pt;font-weight:bold;width:280px;height:16px;overflow:hidden; }
  .s19 { float:left;height:auto;overflow:hidden; }
  .s18 { border-top:Solid 1px Black; }
  .s0 { color:Black;background-color:White;vertical-align:middle;text-align:left;font-family:Arial;font-size:30px;font-weight:bold;width:184px;height:40px;overflow:hidden; }
  .s6 { vertical-align:bottom;text-align:left;font-family:Arial;font-size:12px;font-weight:bold;width:80px;height:16px;overflow:hidden; }
  .s13 { text-align:center;font-family:Arial;font-size:8pt;font-weight:bold;padding-left:5px;width:51px;height:16px;overflow:hidden; }
  .s24 { text-align:left;font-family:Arial;font-size:8pt;font-weight:bold;width:144px;min-height:16px;overflow:visible; }
  .s12 { width:280px; }
  .s20 { font-family:Arial;font-size:8pt;font-weight:bold;width:106px;height:16px;overflow:hidden; }
  .s3 { vertical-align:middle;text-align:left;font-family:Arial;font-size:15px;font-weight:bold;width:112px;height:24px;overflow:hidden; }
  .s32 { font-family:Arial;font-size:8pt;font-weight:bold;width:80px;height:16px;overflow:hidden; }
  .s34 { font-family:Arial;font-size:8pt;font-weight:bold;width:90px;height:16px;overflow:hidden; }
  .s5 { vertical-align:bottom;text-align:left;font-family:Arial;font-size:15px;font-weight:bold;width:112px;height:16px;overflow:hidden; }
  .s30 { vertical-align:bottom;text-align:right;font-family:Arial;font-size:15px;font-weight:bold;width:112px;height:24px;overflow:hidden; }
  .s28 { text-align:right;font-family:Arial;font-size:15px;font-weight:bold;width:112px;height:24px;overflow:hidden; }
  .s36 { text-align:right;font-family:Arial;font-size:8pt;width:120px;height:16px;overflow:hidden; }
  .s22 { text-align:left;font-family:Arial;font-size:8pt;font-weight:bold;width:136px;min-height:16px;overflow:visible; }
  .s26 { font-family:Arial;font-size:8pt;font-weight:bold;width:96px;min-height:16px;overflow:visible; }
  .s1 { font-family:Arial;font-size:15px;width:304px;height:71px;overflow:hidden; }
  .s17 { text-align:center;font-family:Arial;font-size:8pt;font-weight:bold;width:104px;height:16px;overflow:hidden; }
  .s2 { width:304px;height:71px; }
  .s16 { text-align:center;font-family:Arial;font-size:8pt;font-weight:bold;width:88px;height:16px;overflow:hidden; }
  .s21 { text-align:left;font-family:Arial;font-size:8pt;font-weight:bold;width:160px;height:16px;overflow:hidden; }
  .s15 { text-align:center;font-family:Arial;font-size:8pt;font-weight:bold;width:80px;height:16px;overflow:hidden; }
  .s10 { width:56px; }
  .s14 { text-align:center;font-family:Arial;font-size:8pt;font-weight:bold;width:48px;height:16px;overflow:hidden; }
  .s23 { text-align:right;font-family:Arial;font-size:15px;font-weight:bold;padding-top:8px;width:112px;height:24px;overflow:hidden; }
  .s8 { text-align:left;font-family:Arial;font-size:8pt;width:24px;height:16px;overflow:hidden; }
  .s29 { text-align:left;font-family:Arial;font-size:20px;font-weight:bold;text-decoration:underline ;width:432px;height:24px;overflow:hidden; }
  .s7 { vertical-align:bottom;text-align:left;font-family:Arial;font-size:15px;font-weight:bold;width:136px;height:16px;overflow:hidden; }
  .s4 { vertical-align:bottom;font-family:Arial;font-size:15px;font-weight:bold;width:72px;height:16px;overflow:hidden; }
  .s9 { text-align:left;font-family:Arial;font-size:8pt;font-weight:bold;width:56px;height:16px;overflow:hidden; }
  .s33 { font-family:Arial;font-size:8pt;font-weight:bold;width:168px;height:16px;overflow:hidden; }
  .s31 { text-align:left;font-family:Arial;font-size:8pt;font-weight:bold;width:768px;height:32px;overflow:hidden; }
  .s25 { font-size:0pt;border-top:Solid 1px Black;width:144px;height:0px; }
  .s35 { font-family:Arial;font-size:8pt;font-weight:bold;width:160px;height:16px;overflow:hidden; }
  
  /* Custom styles for our receipt */
        .receipt-container {
    min-height:751px;
    width:824px;
    padding:5px;
    margin:0px auto;
    background-color:white;
    border:1px solid #BBBBBB;
    position:relative;
    padding-top:0cm;
    padding-bottom:0cm;
    padding-left:0cm;
    padding-right:0cm;
  }
  
  .receipt-body {
    margin:0px;
    overflow:auto;
    padding:10px;
    background-color:lightgray;
  }
  
  .action-buttons {
    text-align: center;
    margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .btn {
    padding: 10px 20px;
    margin: 0 10px;
            border: none;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    font-weight: bold;
            cursor: pointer;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

  .btn-info {
    background: #17a2b8;
    color: white;
  }
  
        @media print {
            .action-buttons {
                display: none;
            }
    .receipt-body {
      background-color: white;
    }
    header, footer, nav {
      display: none;
            }
        }

    /* Add to the <style> section */
    .s14, .s15, .s16, .s17, .s23, .s28, .s30, .s36 {
        text-align: right !important;
        }
    </style>
</head>
<body>

<nav style="margin-bottom: 20px;" data-depth="3" class="breadcrumb">
    <div class="container">
        <ol>
            <li>
                <a href="index.php"><span>Home</span></a>
            </li>
            <li>
                <a href="orders.php"><span>My Orders</span></a>
            </li>
            <li>
                <span>Receipt</span>
            </li>
        </ol>
                    </div>
</nav>

<section id="wrapper">
    <div class="container">
        <div id="columns_inner">
            <div id="content-wrapper" class="js-content-wrapper">
                <section id="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="receipt-body">
                                <div class="receipt-container">
                                    <div style="position:relative;page-break-after: always">
                                        <table id="ReportTable" cellpadding="0" cellspacing="0" style="background-color:White;">
                                            <tr><td>
                                                <table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                    <colgroup>
                                                        <col style="width: 56px;min-width: 56px"/>
                                                        <col style="width: 112px;min-width: 112px"/>
                                                        <col style="width: 80px;min-width: 80px"/>
                                                        <col style="width: 8px;min-width: 8px"/>
                                                        <col style="width: 64px;min-width: 64px"/>
                                                        <col style="width: 8px;min-width: 8px"/>
                                                        <col style="width: 112px;min-width: 112px"/>
                                                        <col style="width: 24px;min-width: 24px"/>
                                                        <col style="width: 48px;min-width: 48px"/>
                                                        <col style="width: 80px;min-width: 80px"/>
                                                        <col style="width: 144px;min-width: 144px"/>
                                                        <col style="width: 80px;min-width: 80px"/>
                                                        <col style="width: 8px;min-width: 8px"/>
                                                    </colgroup>
                                                    <tr valign="top" style="height:32px;">
                                                        <td colspan="13" />
                                                    </tr>
                                                    <tr valign="top" style="height:24px;">
                                                        <td colspan="4" />
                                                        <td colspan="3" rowspan="2">
                                                            <div class="s0">Receipt</div>
                                                        </td>
                                                        <td colspan="6" />
                                                    </tr>
                                                    <tr valign="top" style="height:16px;">
                                                        <td colspan="4" />
                                                        <td colspan="2" />
                                                        <td colspan="3" rowspan="2">
                                                            <table cellspacing="0" cellpadding="0" border="0">
                                                                <tr>
                                                                    <td class="s1">
                                                                        <div class="s2 wb">
                                                                            <?= htmlspecialchars($user_first_name . ' ' . $user_last_name) ?><br/>
                                                                            <?= htmlspecialchars($user_email) ?><br/>
                                                                            <?= htmlspecialchars($user_phone ?: 'N/A') ?><br/><br/>
                    </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td rowspan="7" />
                                                    </tr>
                                                    <tr valign="top" style="height:55px;">
                                                        <td colspan="9" />
                                                    </tr>
                                                    <tr valign="top" style="height:81px;">
                                                        <td colspan="13" />
                                                    </tr>
                                                    <tr valign="top" style="height:16px;">
                                                        <td rowspan="2" />
                                                        <td rowspan="2">
                                                            <?php if (!empty($order['shipment_number'])): ?>
                                                                <div class="s3"><?= htmlspecialchars($order['shipment_number']) ?></div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td rowspan="3" />
                                                        <td colspan="2">
                                                            <div class="s4">Date:</div>
                                                        </td>
                                                        <td rowspan="3" />
                                                        <td>
                                                            <div class="s5"><?= $payment_date ?></div>
                                                        </td>
                                                        <td colspan="2" />
                                                        <td>
                                                            <div class="s6">Payment Reference</div>
                                                        </td>
                                                        <td />
                                                        <td>
                                                            <div class="s6"><?= htmlspecialchars($order['payment_reference'] ?? 'N/A') ?></div>
                                                        </td>
                                                    </tr>
                                                    <tr valign="top" style="height:8px;">
                                                        <td colspan="2" rowspan="2">
                                                            <div class="s4">Due Date:</div>
                                                        </td>
                                                        <td colspan="2" rowspan="2">
                                                            <div class="s7"><?= $due_date ?></div>
                                                        </td>
                                                        <td colspan="5" />
                                                    </tr>
                                                    <tr valign="top" style="height:8px;">
                                                        <td colspan="3" />
                                                        <td colspan="5" />
                                                    </tr>
                                                    <tr valign="top" style="height:8px;">
                                                        <td colspan="13" />
                                                    </tr>
                                                </table>
                                            </td></tr>
                                            <tr><td>
                                                <table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                    <colgroup>
                                                        <col style="width: 824px;min-width: 824px"/>
                                                    </colgroup>
                                                    <tr valign="top" style="height:31px;">
                                                        <td />
                                                    </tr>
                                                </table>
                                            </td></tr>
                                            
                                            <!-- Items Table -->
                                            <tr><td>
                                                <table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                    <colgroup>
                                                        <col style="width: 24px;min-width: 24px"/>
                                                        <col style="width: 56px;min-width: 56px"/>
                                                        <col style="width: 280px;min-width: 280px"/>
                                                        <col style="width: 8px;min-width: 8px"/>
                                                        <col style="width: 56px;min-width: 56px"/>
                                                        <col style="width: 48px;min-width: 48px"/>
                                                        <col style="width: 16px;min-width: 16px"/>
                                                        <col style="width: 80px;min-width: 80px"/>
                                                        <col style="width: 8px;min-width: 8px"/>
                                                        <col style="width: 88px;min-width: 88px"/>
                                                        <col style="width: 24px;min-width: 24px"/>
                                                        <col style="width: 104px;min-width: 104px"/>
                                                        <col style="width: 32px;min-width: 32px"/>
                                                    </colgroup>
                                                    
                                                    <tr valign="top" style="height:5px;">
                                                        <td colspan="13" />
                            </tr>
                                                    <?php if (!empty($order_items)): ?>
                                                        <?php foreach ($order_items as $index => $item): ?>
                                <?php 
                                // Ensure item is an array and has required keys
                                if (!is_array($item)) continue;
                                
                                $item_name = $item['product_name'] ?? 'Unknown Product';
                                $item_price = floatval($item['selling_price'] ?? 0);
                                $item_quantity = intval($item['quantity'] ?? 0);
                                                            $item_total = $item_price * $item_quantity;
                                                            ?>
                                                            <tr valign="top" style="height:16px;">
                                                                <td>
                                                                    <div class="s8"><?= $index + 1 ?></div>
                                                                </td>
                                                                <td>
                                                                    <table cellspacing="0" cellpadding="0" border="0">
                                                                        <tr>
                                                                            <td class="s9">
                                                                                <div class="s10 wb">
                                                                                    Product
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table cellspacing="0" cellpadding="0" border="0">
                                                                        <tr>
                                                                            <td class="s11">
                                                                                <div class="s12 wb">
                                                                                    <?= htmlspecialchars($item_name) ?>
                                        </div>
                                    </td>
                                </tr>
                    </table>
                                                                </td>
                                                                <td />
                                                                <td>
                                                                    <div class="s13">PCS</div>
                                                                </td>
                                                                <td>
                                                                    <div class="s14"><?= number_format($item_quantity, 2) ?></div>
                                                                </td>
                                                                <td />
                                                                <td>
                                                                    <div class="s15"><?= number_format($item_price, 2) ?></div>
                                                                </td>
                                                                <td />
                                                                <td>
                                                                    <div class="s16">0%</div>
                                                                </td>
                                                                <td />
                                                                <td>
                                                                    <div class="s17"><?= number_format($item_total, 2) ?></div>
                                                                </td>
                                                                <td />
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr valign="top" style="height:16px;">
                                                            <td colspan="13">
                                                                <div style="text-align: center; padding: 20px; color: #6c757d;">
                                                                    No items found for this order.
            </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </td></tr>
                                            
                                            <tr><td>
                                                <table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                    <colgroup>
                                                        <col style="width: 824px;min-width: 824px"/>
                                                    </colgroup>
                                                    <tr valign="top" style="height:124px;">
                                                        <td />
                                                    </tr>
                                                </table>
                                            </td></tr>
                                            
                                            <!-- Summary Section -->
                                            <tr><td>
                                                <table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                    <colgroup>
                                                        <col style="width: 824px;min-width: 824px"/>
                                                    </colgroup>
                                                    <tr valign="top" style="height:24px;">
                                                        <td />
                                                    </tr>
                                                    <tr valign="top" style="height:144px;">
                                                        <td>
                                                            <table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;" class="s18">
                                                                <colgroup>
                                                                    <col style="width: 16px;min-width: 16px"/>
                                                                    <col style="width: 106px;min-width: 106px"/>
                                                                    <col style="width: 6px;min-width: 6px"/>
                                                                    <col style="width: 136px;min-width: 136px"/>
                                                                    <col style="width: 8px;min-width: 8px"/>
                                                                    <col style="width: 8px;min-width: 8px"/>
                                                                    <col style="width: 8px;min-width: 8px"/>
                                                                    <col style="width: 40px;min-width: 40px"/>
                                                                    <col style="width: 48px;min-width: 48px"/>
                                                                    <col style="width: 88px;min-width: 88px"/>
                                                                    <col style="width: 88px;min-width: 88px"/>
                                                                    <col style="width: 120px;min-width: 120px"/>
                                                                    <col style="width: 112px;min-width: 112px"/>
                                                                    <col style="width: 40px;min-width: 40px"/>
                                                                </colgroup>
                                                                <tr valign="top" style="height:8px;">
                                                                    <td colspan="8" />
                                                                    <td colspan="2" rowspan="8">
                                                                        <div class="s19">
                                                                            <img width="136px" height="112px" alt="Logo" src="assets/imgs/logo/logo.png" />
                </div>
                                                                    </td>
                                                                    <td colspan="4" />
                                                                </tr>
                                                                <tr valign="top" style="height:16px;">
                                                                    <td rowspan="2" />
                                                                    <td>
                                                                        <div class="s20">Payment Method:</div>
                                                                    </td>
                                                                    <td rowspan="2" />
                                                                    <td colspan="4">
                                                                        <div class="s21"><?= htmlspecialchars($payment_method) ?></div>
                                                                    </td>
                                                                    <td rowspan="7" />
                                                                    <td colspan="4" />
                                                                </tr>
                                                                <tr valign="top" style="height:16px;">
                                                                    <td>
                                                                        <div class="s20">Order Status:</div>
                                                                    </td>
                                                                    <td colspan="4">
                                                                        <div class="s21">Paid</div>
                                                                    </td>
                                                                    <td colspan="4" />
                                                                </tr>
                                                                <tr valign="top" style="height:8px;">
                                                                    <td colspan="8" />
                                                                    <td colspan="4" />
                                                                </tr>
                                                                <tr valign="top" style="height:16px;">
                                                                    <td rowspan="2" />
                                                                    <td>
                                                                        <div class="s20">Shipping:</div>
                                                                    </td>
                                                                    <td rowspan="2" />
                                                                    <td>
                                                                        <div class="s22"><?= htmlspecialchars($order['destination'] ?? 'N/A') ?></div>
                                                                    </td>
                                                                    <td colspan="4" />
                                                                    <td colspan="4" />
                                                                </tr>
                                                                
                                                                <tr valign="top" style="height:16px;">
                                                                    <td colspan="8" />
                                                                    <td colspan="2" />
                                                                </tr>
                                                                <tr valign="top" style="height:8px;">
                                                                    <td colspan="8" />
                                                                    <td colspan="4" />
                                                                </tr>
                                                               
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr valign="top" style="height:7px;">
                                                        <td />
                                                    </tr>
                                                </table>
                                            </td></tr>
                                            
                                            <!-- Total Section -->
                                            <tr><td>
                                                <table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                    <colgroup>
                                                        <col style="width: 32px;min-width: 32px"/>
                                                        <col style="width: 80px;min-width: 80px"/>
                                                        <col style="width: 168px;min-width: 168px"/>
                                                        <col style="width: 16px;min-width: 16px"/>
                                                        <col style="width: 90px;min-width: 90px"/>
                                                        <col style="width: 6px;min-width: 6px"/>
                                                        <col style="width: 152px;min-width: 152px"/>
                                                        <col style="width: 8px;min-width: 8px"/>
                                                        <col style="width: 120px;min-width: 120px"/>
                                                        <col style="width: 24px;min-width: 24px"/>
                                                        <col style="width: 88px;min-width: 88px"/>
                                                        <col style="width: 16px;min-width: 16px"/>
                                                        <col style="width: 16px;min-width: 16px"/>
                                                        <col style="width: 8px;min-width: 8px"/>
                                                    </colgroup>
                                                    <tr valign="top" style="height:8px;">
                                                        <td colspan="14" />
                                                    </tr>
                                                    <tr valign="top" style="height:24px;">
                                                        <td colspan="11">
                                                            <div class="s29">THANK YOU FOR YOUR PURCHASE</div>
                                                        </td>
                                                      
                                                    </tr>
                                                    <tr valign="top" style="height:32px;">
                                                        <td rowspan="3" />
                                                        <td colspan="11">
                                                            <div class="s31">This receipt serves as proof of payment for your order. Please keep it for your records.</div>
                                                        </td>
                                                        <td colspan="2" />
                                                    </tr>
                                                    <tr valign="top" style="height:8px;">
                                                        <td rowspan="2">
                                                            <div class="s32">Printed on:</div>
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="s33"><?= $printed_date ?></div>
                                                        </td>
                                                        <td rowspan="2" />
                                                        <td rowspan="2">
                                                            <div class="s34">Printed by:Mark</div>
                                                        </td>
                                                        <td rowspan="2" />
                                                        <td colspan="2" rowspan="2">
                                                            <div class="s35"><?= htmlspecialchars($user_first_name . ' ' . $user_last_name) ?></div>
                                                        </td>
                                                        <td colspan="6" />
                                                    </tr>
                                                    <tr valign="top" style="height:8px;">
                                                        <td colspan="2" />
                                                        <td colspan="3" rowspan="2">
                                                            <div class="s36">Page: 1 of 1</div>
                                                        </td>
                                                        <td rowspan="2" />
                                                    </tr>
                                                    <tr valign="top" style="height:8px;">
                                                        <td colspan="10" />
                                                    </tr>
                                                </table>
                                            </td></tr>
                                        </table>
                    </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Receipt
            </button>
                                
                                <a href="order-details.php?token=<?= urlencode($token) ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> View Order Details
            </a>
                                
                                <a href="orders.php" class="btn btn-success">
                                    <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>
        </div>
    </div>
                </section>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Handle URL parameters for SweetAlert messages -->
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    const messageType = urlParams.get('message_type');
    
    // If message parameters exist, show SweetAlert
    if (message && messageType) {
        // Determine icon based on message type
        let icon = 'info';
        switch(messageType) {
            case 'success':
                icon = 'success';
                break;
            case 'error':
            case 'danger':
                icon = 'error';
                break;
            case 'warning':
                icon = 'warning';
                break;
            default:
                icon = 'info';
        }
        
        // Show SweetAlert toast
        Swal.fire({
            position: 'top-end',
            icon: icon,
            title: message,
            toast: true,
            showConfirmButton: false,
            timer: 3000,
            width: 'auto',
            padding: '0.1em',
            background: 'white',
            customClass: {
                container: 'my-swal-container'
            }
        });
        
        // Clean up URL parameters without page reload
        const newUrl = window.location.pathname + '?token=' + urlParams.get('token');
        window.history.replaceState({}, document.title, newUrl);
    }
});
    </script>

</body>
</html>
