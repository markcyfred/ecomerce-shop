-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2025 at 01:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `size` varchar(50) NOT NULL,
  `banner_type` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `price`, `image`, `link`, `status`, `size`, `banner_type`, `created_at`, `updated_at`) VALUES
(1, 'Laptop Bags', 'Work Ready', 1800.00, '1749492092.png', 'n/a', 1, 'normal', 'single', '2025-06-09 20:44:28', '2025-06-09 21:01:32'),
(2, 'Sport Shoes', 'Run Easy', 600.00, '1749492121.png', 'n.z', 1, 'normal', 'single', '2025-06-09 20:46:45', '2025-06-09 21:02:01'),
(3, 'Dresses', 'Chic Look', 500.00, '1749492141.png', 'shop.php', 1, 'normal', 'single', '2025-06-09 20:47:24', '2025-06-09 21:02:21'),
(4, 'Formal Shoes', 'Office Style', 2300.00, '1749491392.png', 'pm', 1, 'large', 'double', '2025-06-09 20:49:52', '2025-06-09 20:58:03'),
(5, 'Shirts', 'Top Wear', 800.00, '1749491446.png', 'http://localhost/ecomerce-shop/banners.php', 1, 'large', 'double', '2025-06-09 20:50:46', '2025-06-09 20:58:03'),
(6, 'Top dresses', 'tp', 1200.00, '1749492310.png', 'fd', 1, 'large', 'double', '2025-06-09 21:05:10', '2025-06-09 21:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author_name` varchar(100) NOT NULL DEFAULT 'admin',
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(500) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `published_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `category`, `title`, `slug`, `author_name`, `description`, `image`, `meta_keywords`, `status`, `published_date`, `created_at`, `updated_at`) VALUES
(1, 'Marketing', 'The 9 Habits of Highly Successful Content Creators this Year', 'the-9-habits-of-highly-successful-content-creators-this-year', 'admin', 'Think About How The Offering Will Support The Customer By bringing a new perspective to the table, you can help an invigorate your marketing departmentâ€™s efforts Brainstorm an ideas with colleagues or create content around questions.\r\n\r\nOdio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.\r\n\r\nCommodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.\r\n\r\nDonec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.\r\n\r\nSed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.\r\n\r\nMi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend ps mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.', '1749208580-3820.jpg', ' Blogging Community Educational Science Photography', 1, '2025-06-06', '2025-06-06 14:16:20', '2025-06-06 14:16:20'),
(2, 'Social Media', 'How to Create a Social Media Calendar to Plan Your Content', 'how-to-create-a-social-media-calendar-to-plan-your-content', 'admin', 'The MarketWatch News Department was not involved in the creation of this content. Potential buyers are unlikely to remember every single feature of the product they are considering. A few key benefits will stick out in their minds, along with the feeling of owning it.\r\n\r\nOdio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.\r\n\r\nCommodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.\r\n\r\nDonec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.\r\n\r\nSed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.\r\n\r\nMi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend ps mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.', '1749208641-1759.jpg', ' Knowledge Learning Management Science Community', 1, '2025-06-06', '2025-06-06 14:17:21', '2025-06-06 14:17:21'),
(3, 'Business', 'How to Build a Detailed Business Plan That Stands Out', 'how-to-build-a-detailed-business-plan-that-stands-out', 'admin', 'Expedita consequatur aut sed eaque minus Mollitia consequatur ipsum ut eaque illum sint. Sapiente ea explicabo. Lure esse quia Ducimus voluptatem dolores eos sunt. Aliquam amet corporis natus voluptate voluptatem.\r\n\r\nQui rerum voluptatem eligendi eum reprehenderit. Amet quos odit recusandae aut accusantium rerum. numquam occaecati nihil Ipsum eos enim doloribus quas. temporibus quis velit. Est accusamus commodi. Veniam quia aliquid blanditiis velit. Eligendi illo dolores aperiam. est maxime animi ut accusamus. Rem rerum sit ipsum consequatur numquam porro. nihil a in mollitia. ut aut saepe. Alias iusto debitis aut Accusantium enim voluptatum sint. Qui ex et aut aut ut Omnis omnis veritatis ut repellat enim. Qui dolores ad molestias eius nobis Vel odio veritatis. velit sed reprehenderit qui ipsa. dignissimos laboriosam et at magni quam. Officiis sed eligendi dolore. iste perspiciatis. Distinctio unde cumque blanditiis.\r\n\r\nImpedit voluptate enim aut in est. Illo voluptas eaque quis pariatur\r\nFugit et autem molestiae quibusdam. reiciendis velit deserunt aliquam quo. Odio laboriosam quas minima incidunt A dicta aut nulla velit. Ab quisquam qui id sunt. sunt ab eveniet eveniet molestiae. Eaque non maiores iste aut ullam accusamus. Voluptatem ullam in quo consectetur. quia ut aut ut fuga. in consequatur dolorem vel nihil animi molestiae. Corporis saepe molestias voluptatem officia. porro ut tenetur ut est veritatis. Vel numquam culpa autem ut magnam dolores ducimus. temporibus cupiditate aut ut. similique quas suscipit corrupti id ut. Ipsam dolores similique distinctio error. Dignissimos vitae recusandae nisi distinctio. Vel fugiat dolore officiis enim Id consequatur ut et nihil. Molestiae est enim itaque accusantium. id delectus sapiente harum in molestiae.\r\n\r\nMi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend ps mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.', '1749208695-4976.jpg', ' Community Educational Experiences Knowledge Learning', 1, '2025-06-06', '2025-06-06 14:18:15', '2025-06-06 14:18:15'),
(4, 'Business', 'Customer Experience Trends That will Define the Next Year', 'customer-experience-trends-that-will-define-the-next-year', 'admin', 'Debitis saepe fugiat nisi consequatur. Nihil sed eos dignissimos consequatur. Id veritatis Aliquid sed facilis a totam. aut ipsa sint qui. Ratione facere repellat sunt. commodi est voluptas placeat. Suscipit quis perspiciatis sint asperiores velit. Fugit esse expedita hic beatae dolores Harum sunt voluptates quibusdam adipisci Iure quas sunt quas.\r\n\r\nPerferendis eius eum enim id. animi quia. error omnis tempore. Eos ducimus molestias velit dolor quo. Et odio dolore ea atque. laborum ea quas iusto dolores. Corporis eligendi est non. molestiae ex et Accusantium voluptatem dolore ea deleniti vitae. In sed culpa Commodi similique quia rem. Debitis saepe fugiat nisi consequatur. Nihil sed eos dignissimos consequatur. Id veritatis Aliquid sed facilis a totam. aut ipsa sint qui. Ratione facere repellat sunt. commodi est voluptas placeat. Suscipit quis perspiciatis sint asperiores velit. Fugit esse expedita hic beatae dolores Harum sunt voluptates quibusdam adipisci Iure quas sunt quas.\r\n\r\nPost-ironic sriracha 8-bit vice hashtag raw denim offal humblebrag. Food truck cloud bread 8-bit, letterpress twee waistcoat leggings shoreditch fanny pack you probably havenâ€™t heard of them. Gluten-free four loko twee pork belly brooklyn. Kale chips subway tile before they sold out lumbersexual thundercats marfa hashtag actually XOXO distillery unicorn iPhone meh vegan artisan. Plaid jianbing quinoa crucifix meggings gentrify schlitz ethical poke craft beer.\r\n\r\nAuthentic vexillologist thundercats, kale chips next level flannel activated charcoal keffiyeh single-origin coffee lo-fi swag stumptown marfa dreamcatcher. Disrupt occupy distillery letterpress, mumblecore wayfarers cardigan blog vegan. Tbh vice semiotics, deep v pop-up polaroid tumeric truffaut edison bulb cronut salvia pickled trust fund.\r\n\r\nWhy you should not eat cheap cruise in bed. 8 things about dog friendly hotels your kids dont want you to know.\r\nPost-ironic sriracha 8-bit vice hashtag raw denim offal humblebrag. Food truck cloud bread 8-bit, letterpress twee waistcoat leggings shoreditch fanny pack you probably havenâ€™t heard of them. Gluten-free four loko twee pork belly brooklyn. Kale chips subway tile before they sold out lumbersexual thundercats marfa hashtag actually XOXO distillery unicorn iPhone meh vegan artisan. Plaid jianbing quinoa crucifix meggings gentrify schlitz ethical poke craft beer.\r\n\r\nWaistcoat palo santo forage, retro flannel kitsch brooklyn sriracha. Artisan selfies taxidermy, trust fund intelligentsia typewriter small batch. Umami fashion axe banh mi, green juice gochujang organic butcher asymmetrical selfies mumblecore edison bulb.', '1749208749-7543.jpg', ' Networking Photography Blogging Community Experiences', 1, '2025-06-06', '2025-06-06 14:19:09', '2025-06-06 14:19:09'),
(5, 'Social Media', 'How to Write a Blog Post Outline: A Simple Formula to Follow', 'how-to-write-a-blog-post-outline-a-simple-formula-to-follow', 'admin', 'Get To Know The Audience From Different Points Of View Copy should be tailored for each stage of the customer journey. For example, a new-to-market lipstick brand might find success with awareness ads highlighting.\r\n\r\nSed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quas.\r\n\r\nSuspendisse posuere, diam in bibendum lobortis, turpis ipsum aliquam risus, sit amet dictum ligula lorem non nisl. Ut vitae nibh id massa vulputate euismod ut quis justo. Ut bibendum sem at massa lacinia, eget elementum ante consectetur. Nulla id pharetra dui, at rhoncus urna. Maecenas non porttitor purus. Nullam ullamcorper nisl quis ornare molestie.\r\n\r\nEtiam eget erat est. Phasellus elit justo, mattis non lorem non, aliquam aliquam ps. Sed fermentum consectetur magna, eget semper ante. Aliquam scelerisque justo velit. Fusce cursus blandit dolor, in sodales urna vulputate lobortis. Nulla ut tellus turpis. Nullam lacus sem, volutpat id odio sed, cursus tristique eros. Duis at pellentesque magna. Donec magna nisi, vulputate ac nulla eu, ultricies tincidunt tellus. Nunc tincidunt sem urna, nec venenatis libero vehicula ut.\r\n\r\nVestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur faucibus aliquam pulvinar. Vivamus mattis volutpat erat, et congue nisi semper quis. Cras vehicula dignissim libero in elementum. Mauris sit amet dolor justo. Morbi consequat velit vel est fermentum euismod. Curabitur in magna augue.', '1749208802-5085.jpg', 'Community Educational Learning Management Science', 1, '2025-06-06', '2025-06-06 14:20:02', '2025-06-06 14:20:02'),
(6, 'Business', 'Top 9 Content Marketing Trends and Ideas to Increase Traffic', 'top-9-content-marketing-trends-and-ideas-to-increase-traffic', 'admin', 'What You Need to Know about the Facebook Product Design Interview and What to do about it. Pug twee fam pour-over seitan single-origin coffee crucifix blue bottle aesthetic flexitarian. Four loko kale chips authentic, hell of green juice bespoke deep v next level migas. Woke bushwick prism live-edge austin tote bag.\r\n\r\nWhat You Need to Know about the Facebook Product Design Interview and What to do about it. Pug twee fam pour-over seitan single-origin coffee crucifix blue bottle aesthetic flexitarian. Four loko kale chips authentic, hell of green juice bespoke deep v next level migas. Woke bushwick prism live-edge austin tote bag. Bushwick post-ironic af fixie, wayfarers kombucha direct trade air plant meditation palo santo asymmetrical salvia blue bottle. 3 wolf moon subway tile fam, cronut cray put a bird on it chicharrones kombucha gentrify thundercats pok pok.\r\n\r\nWhatever wolf leggings yuccie +1 90â€™s, austin ennui listicle hashtag church-key master cleanse hexagon mlkshk kitsch. Dreamcatcher ugh jianbing palo santo blog hashtag brunch. Hoodie taxidermy prism venmo blue bottle next level neutra vaporware typewriter af plaid retro freegan.\r\n\r\nWhat You Need to Know about the Facebook Product Design Interview and What to do about it\r\nVinyl lumbersexual hella hot chicken aesthetic, intelligentsia raclette gentrify activated charcoal VHS. Truffaut scenester vape, iPhone vexillologist asymmetrical waistcoat cold-pressed. Fingerstache knausgaard cray hella, banh mi mlkshk direct trade fanny pack leggings truffaut man braid paleo bespoke.\r\n\r\nWaistcoat palo santo forage, retro flannel kitsch brooklyn sriracha. Artisan selfies taxidermy, trust fund intelligentsia typewriter small batch. Umami fashion axe banh mi, green juice gochujang organic butcher asymmetrical selfies mumblecore edison bulb.', '1749208851-7515.jpg', ' Educational Experiences Learning Management Science', 1, '2025-06-06', '2025-06-06 14:20:51', '2025-06-06 14:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Business', 'business', 'Think About How The Offering Will Support The Customer By bringing a new perspective to the table, you can help an invigorate your marketing departmentâ€™s efforts Brainstorm an ideas with colleagues or create content around questions that have come up with during your onboarding process.', 1, '1749208426.jpg', '2025-06-06 14:13:46', '2025-06-06 14:13:46'),
(2, 'Social Media', 'social-media', 'The MarketWatch News Department was not involved in the creation of this content. Potential buyers are unlikely to remember every single feature of the product they are considering. A few key benefits will stick out in their minds, along with the feeling of owning it. The product message communicates the key features and benefits.\r\n\r\n', 1, '1749208457.jpg', '2025-06-06 14:14:17', '2025-06-06 14:14:17'),
(3, 'Marketing', 'marketing', 'Despite the presence of intense competition, the global recovery trend shows clear, investors are still optimistic about this area, and it will still be more new investments entering the field in the future. With aim that clearly revealing the competitive situation for industry, we concretely analyze not only leading enterprises that have voice global.\r\n\r\n', 1, '1749208490.jpg', '2025-06-06 14:14:50', '2025-06-06 14:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_image` varchar(255) NOT NULL,
  `brand_description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_image`, `brand_description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nike', '1743250943.png', 'Nike is a global leader in athletic shoes\r\nand apparel.', 1, '2025-03-21 11:43:20', '2025-03-29 12:22:23'),
(2, 'Adidas', '1743249921.png', 'Adidas is known for innovative sportswear and fashion-forward designs.', 1, '2025-03-21 11:43:20', '2025-03-29 12:05:21'),
(3, 'Puma', '1743250205.png', 'Puma offers high-quality athletic and casual footwear and clothing.', 1, '2025-03-21 11:43:20', '2025-03-29 12:10:05'),
(4, 'Mkurugenzi', '1743250228.jpg', 'Mkurugenzi is a trendy online boutique specializing in contemporary clothing and shoes.', 1, '2025-03-21 11:43:20', '2025-03-29 12:10:28'),
(5, 'GoPrimeHost', '1743250251.jpg', 'GoPrimeHost stands out as an online boutique offering exclusive styles in clothing and shoes.', 1, '2025-03-21 11:43:20', '2025-03-29 12:10:51'),
(6, 'Gucci', '1743250670.png', 'Gucci brings modern elegance to everyday fashion with unique designs.', 1, '2025-03-21 11:43:20', '2025-03-29 12:17:50'),
(7, 'Swahili Elegance', '1743250709.jpg', 'Swahili Elegance features a blend of traditional and modern fashion pieces for a unique look.', 1, '2025-03-21 11:43:20', '2025-03-29 12:18:29'),
(8, 'N/A', '1743250791.png', 'This option is used for products without a specific brand.', 1, '2025-03-21 11:43:20', '2025-03-29 12:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cart_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_id` varchar(255) DEFAULT NULL,
  `cart_status` enum('unprocessed','processed') NOT NULL DEFAULT 'unprocessed',
  `checkout_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `product_name`, `selling_price`, `image`, `quantity`, `user_id`, `email`, `cart_order`, `created_at`, `updated_at`, `session_id`, `cart_status`, `checkout_id`) VALUES
(2, 29, 'Men demin Jeans', 4512.00, '1743057068.jpg', 1, 14, 'mark1kinai1@gmail.com', 1, '2025-06-21 10:08:47', '2025-06-21 10:10:34', 'hasqko5p9vaet0n1qqa0ap6egj', 'processed', 1),
(3, 28, 'Chelsea 24/25 Home Kit New Season', 1400.00, '1732627302.avif', 1, 14, 'mark1kinai1@gmail.com', 1, '2025-06-21 10:11:45', '2025-06-21 10:11:45', 'hasqko5p9vaet0n1qqa0ap6egj', 'unprocessed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `popularity` tinyint(1) DEFAULT 0,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `popularity`, `meta_title`, `meta_description`, `meta_keywords`, `image`, `created_at`) VALUES
(1, 'Men Shoes', 'Men Shoes', 'A wide variety of stylish and comfortable shoes for men, including formal, casual, and sports shoes.', 1, 1, 'Men Shoes - Stylish and Comfortable Footwear for Men', '  Explore our exclusive collection of men\'s shoes. Find the perfect pair for every occasion, from formal to casual styles.', 'men shoes, formal shoes, casual shoes, sports shoes, stylish men\'s footwear', '1732550227.jpg', '2024-11-25 15:57:07'),
(2, ' Women Shoes', 'women-shoes', 'Discover a diverse range of women\'s shoes, from heels to flats and everything in between, perfect for all occasions.', 1, 1, 'Women Shoes - Trendy and Comfortable Footwear for Women', 'Browse our stunning collection of women\'s shoes. From elegant heels to casual flats, find the right pair for your style.', 'women shoes, heels, flats, sandals, stylish women\'s footwear', '1732550296.jpg', '2024-11-25 15:58:16'),
(3, 'Men Clothing', 'Men Clothing', 'A collection of stylish and trendy clothing for men, women, and children, for both casual and formal occasions.', 1, 1, 'Clothing - Fashionable Apparel for All Ages', ' Shop a wide selection of clothing for men, women, and kids. Find casual wear, formal wear, and everything in between.', 'clothing, casual wear, formal wear, fashion, apparel', '1732615725.jpg', '2024-11-25 15:59:29'),
(4, 'Accessories', 'accessories', 'Complete your look with stylish accessories such as bags, hats, scarves, and jewelry to match your outfit.', 1, 1, 'Accessories - Stylish Bags, Hats, and More', 'Find the perfect accessories to complement your style. Shop our range of bags, belts, scarves, and other trendy items.', 'accessories, bags, scarves, hats, jewelry, stylish accessories', '1732550432.jpg', '2024-11-25 16:00:32'),
(5, 'Jewelry', 'Jewelry', 'A beautiful selection of necklaces, rings, earrings, and bracelets that add sparkle and elegance to any outfit.', 1, 1, 'Jewelry - Elegant Necklaces, Rings, and More', 'Browse our exquisite collection of jewelry for every occasion. From timeless rings to elegant necklaces, find the perfect piece.', 'jewelry, necklaces, rings, earrings, bracelets, elegant jewelry', '1732550519.jpg', '2024-11-25 16:01:59'),
(6, 'Kids Wear', 'kids-wear', 'Fashionable and comfortable clothing for kids, from baby clothes to school uniforms, designed for everyday use.', 1, 1, 'Kids Wear - Comfortable and Stylish Clothing for Children', 'Shop our collection of kids\' clothing for all ages. From baby clothes to school uniforms, keep your child stylish and comfortable.', 'kids wear, children\'s clothing, baby clothes, school uniforms, kids fashion', '1732550671.jpg', '2024-11-25 16:04:31'),
(7, 'Women Clothing', 'women-clothing', 'A wide selection of trendy and stylish clothing for women, including casual wear, formal attire, and seasonal collections.', 1, 1, 'Women Clothing - Trendy Apparel for Every Occasion', '  Shop the latest styles in women\'s clothing, from casual outfits to elegant formal wear and seasonal must-haves.', 'women clothing, casual wear, formal wear, trendy outfits, women fashion', '1732638370.jpg', '2024-11-25 16:07:11');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) NOT NULL,
  `shipment_number` varchar(50) DEFAULT NULL,
  `cart_subtotal` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `destination` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `user_lat` decimal(10,6) DEFAULT NULL,
  `user_lng` decimal(10,6) DEFAULT NULL,
  `destination_lat` decimal(10,6) DEFAULT NULL,
  `destination_lng` decimal(10,6) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','paid','processing','shipped','delivered','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `distance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`id`, `user_id`, `session_id`, `shipment_number`, `cart_subtotal`, `shipping_cost`, `total_amount`, `discount`, `destination`, `state`, `postcode`, `user_lat`, `user_lng`, `destination_lat`, `destination_lng`, `created_at`, `status`, `distance`) VALUES
(1, 14, 'hasqko5p9vaet0n1qqa0ap6egj', 'SH20250621A8A0A9', 4512.00, 100.00, 3709.60, 902.40, 'Nairobi', 'Nairobi County', '00100', -1.286389, 36.817223, -1.286389, 36.817223, '2025-06-21 13:10:34', 'pending', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `blog_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `likes` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `blog_id`, `user_name`, `user_email`, `comment`, `likes`, `created_at`) VALUES
(1, 1, 'adminbbbb', 'mark1kinai1@gmail.com', 'sf', 0, '2025-06-06 20:41:00'),
(2, 1, 'adminbbbb', 'mark1kinai1@gmail.com', 'gfg', 0, '2025-06-06 20:49:46'),
(3, 1, 'adminbbbb', 'mark1kinai1@gmail.com', 'gfg', 0, '2025-06-06 20:49:56'),
(4, 1, 'adminbbbb', 'mark1kifdffnai1@gmail.com', 'fd', 0, '2025-06-06 20:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cart_order` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`id`, `product_id`, `product_name`, `selling_price`, `image`, `quantity`, `user_id`, `email`, `cart_order`, `created_at`, `updated_at`, `session_id`) VALUES
(1, 27, 'Manchester United Jersey ', 1700.00, '1732627742.avif', 1, NULL, NULL, 1, '2025-06-11 19:27:11', '2025-06-11 19:27:11', '73ra0bbugb9oe0j6n2tmh1s9ei');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `feedback` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = pending, 1 = approved',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `product_id`, `name`, `email`, `title`, `feedback`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 7, 'Alice Mwangi', 'alice.mwangi@gmail.com', 'Excellent Quality', 'I was really impressed with the build quality of this product. Exceeded my expectations!', 'alice_mwangi.jpg', 1, '2025-05-20 14:32:00', '2025-05-20 14:32:00'),
(4, 7, 'Alice Mwangi', 'alice.mwangi@gmail.com', 'Excellent Quality', 'I was really impressed with the build quality of this product. Exceeded my expectations!', 'alice_mwangi.jpg', 1, '2025-05-20 14:32:00', '2025-05-20 14:32:00'),
(5, 7, 'Alice Mwangi', 'alice.mwangi@gmail.com', 'Excellent Quality', 'I was really impressed with the build quality of this product. Exceeded my expectations!', 'alice_mwangi.jpg', 1, '2025-05-20 14:32:00', '2025-05-20 14:32:00'),
(6, 19, 'Brian Otieno', 'brian.otieno@gmail.com', 'Fast Delivery', 'The product arrived much sooner than anticipated. Very happy with the service!', NULL, 1, '2025-05-22 09:15:00', '2025-05-22 09:15:00'),
(7, 12, 'Catherine Njoroge', 'catherine.njoroge@gmail.com', 'Value for Money', 'Great value for the price. Will definitely order again in the future.', 'catherine_njoroge.png', 1, '2025-05-23 11:45:00', '2025-05-23 11:45:00'),
(8, 25, 'David Kimani', 'david.kimani@gmail.com', 'User-Friendly', 'The setup was straightforward and the user guide was very helpful. Kudos to the team!', 'david_kimani.jpg', 1, '2025-05-24 16:08:00', '2025-05-24 16:08:00'),
(9, 3, 'Emily Wanjiku', 'emily.wanjiku@gmail.com', 'Highly Recommend', 'I recommend this to all my colleagues. It performs exactly as advertised.', NULL, 1, '2025-05-25 10:20:00', '2025-05-25 10:20:00'),
(10, 21, 'Frank Otieno', 'frank.otieno@gmail.com', 'Solid Build', 'Sturdy construction and reliable performance. Very satisfied with this purchase.', 'frank_otieno.jpg', 1, '2025-05-26 13:50:00', '2025-05-26 13:50:00'),
(11, 14, 'Grace Achieng', 'grace.achieng@gmail.com', 'Five Stars', 'Amazing product! It works seamlessly and delivers exactly what I need.', 'grace_achieng.png', 1, '2025-05-27 08:30:00', '2025-05-27 08:30:00'),
(12, 5, 'Henry Kagere', 'henry.kagere@gmail.com', 'Very Satisfied', 'Customer support was quick to respond and solved my issue within minutes.', NULL, 1, '2025-05-28 17:05:00', '2025-05-28 17:05:00'),
(13, 29, 'Mark Kinai', 'markkinai3@gmail.com', 'absa', 'asa', NULL, 0, '2025-06-06 23:36:22', '2025-06-06 23:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `blog_id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `blog_id`, `ip_address`, `created_at`) VALUES
(1, 1, '::1', '2025-06-06 20:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `rating` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 0,
  `discount` float DEFAULT 0,
  `deal_start` datetime DEFAULT NULL,
  `deal_end` datetime DEFAULT NULL,
  `deal_of_day_status` enum('open','closed') DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `trending` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `size` varchar(255) DEFAULT NULL,
  `featured` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `sale_out_limit` varchar(50) NOT NULL DEFAULT 'no limit' COMMENT 'Max units allowed per order. "no limit" = no limit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_name`, `rating`, `status`, `discount`, `deal_start`, `deal_end`, `deal_of_day_status`, `product_name`, `description`, `original_price`, `selling_price`, `image`, `quantity`, `trending`, `created_at`, `updated_at`, `size`, `featured`, `brand_name`, `sale_out_limit`) VALUES
(1, 'Men Shoes', 4, 1, 3, NULL, NULL, NULL, 'MISSLAI shoes', 'MISSLAI Men\\\'s Basketball Shoes Breathable High Top Stretch Sneakers.', 2338.00, 2268.00, '1742628937.jpg', 35, 1, '2024-11-25 16:10:13', '2025-06-16 16:39:10', '', 'new', '', '5'),
(2, 'Men Shoes', 3, 1, 43, NULL, NULL, NULL, 'Basketball Shoes', 'Men\'s Basketball Shoes PU Sports Shoes Running Shoes', 1999.00, 1139.00, '1732551155.jpg', 25, 1, '2024-11-25 16:12:35', '2025-06-16 16:39:10', '', 'best_selling', '', '10'),
(3, 'Men Shoes', 2, 1, 1, NULL, NULL, NULL, 'Sports Shoes', 'Fashion Men\\\'s Basketball Shoes PU Sports Shoes Running Shoes.', 2743.00, 2606.00, '1732551233.jpg', 110, 1, '2024-11-25 16:13:53', '2025-06-16 16:39:10', '', 'exclusive', '', '10'),
(4, 'Men Shoes', 5, 1, 2, NULL, NULL, NULL, 'Basketball Sneakers', 'Fashion Men\\\'s Breathable Basketball Sneakers Trend Boy\\\'s Basketball Shoes Hight Cut Outdoor BasketBall Shoes For Men Shoes', 4679.00, 4445.00, '1732551333.jpg', 150, 1, '2024-11-25 16:15:33', '2025-06-16 16:39:10', '', 'featured', '', '5'),
(5, 'Men Shoes', 4, 1, 5, NULL, NULL, NULL, 'Basketball Shoes Non-Slip', 'Fashion Basketball Shoes, Non-Slip, Wear-Resistant, Breathable Sports Shoes Purple', 4700.00, 4060.00, '1732551678.jpg', 50, 1, '2024-11-25 16:21:18', '2025-06-16 16:39:10', 'medium', 'popular', '', '12'),
(6, 'Men Shoes', 5, 1, 28, NULL, NULL, NULL, 'Fashion Black Laced', 'Fashion Black Laced Official Leather Shoes For Men', 2500.00, 1500.00, '1732607538.jpg', 25, 1, '2024-11-25 16:26:10', '2025-06-16 16:39:10', 'large', 'featured', '', '8'),
(7, 'Men Shoes', 3, 1, 51, NULL, NULL, NULL, 'Fashion Official Laced', 'Fashion Official Laced Leather Shoes - Brown\\r\\n', 3780.00, 1900.00, '1732552111.jpg', 10, 1, '2024-11-25 16:28:31', '2025-06-16 16:39:10', 'medium', 'new', '', '11'),
(8, 'Men Shoes', 3, 1, 6, NULL, NULL, NULL, 'Fashion Official Laced', 'Fashion Official Laced Suede Leather Shoes - Navy Blue', 3500.00, 3000.00, '1732552181.jpg', 25, 1, '2024-11-25 16:29:41', '2025-06-16 16:39:10', 'medium', 'featured', '', '7'),
(9, 'Men Shoes', 4, 1, 26, NULL, NULL, NULL, 'Fashion Men running shoes', 'Fashion Men\\\'s Comfortable Gentle Casual Sport Running Sneakers Shoes Solid White', 1500.00, 1200.00, '1732552542.jpg', 25, 1, '2024-11-25 16:35:42', '2025-06-16 16:39:10', 'Select Size', 'trending', '', '9'),
(10, 'Men Clothing', 3, 1, 59, NULL, NULL, NULL, 'Mens Berrykey Polo', 'Berrykey Men\\\'s Casual Vintage Turtleneck Polo Long Sleeve Office Shirts', 1200.00, 1000.00, '1732552650.jpg', 23, 1, '2024-11-25 16:37:30', '2025-06-16 16:39:10', '', '', '', '7'),
(11, 'Men Clothing', 5, 1, 7, NULL, NULL, NULL, 'Berrykey Mens Hawaiian', 'Berrykey Men\\\'s Hawaiian Ink Print Bottom-down Beach Short Sleeve T-Shirt Casual Tops', 950.00, 900.00, '1732552849.jpg', 52, 1, '2024-11-25 16:40:49', '2025-06-16 16:39:10', 'medium', 'featured', '', '5'),
(12, 'Jewelry', 3, 1, 27, NULL, NULL, NULL, 'Golden Rings Women', '17 Pcs Golden Rings Women Bohemian Rings Jewelry', 300.00, 250.00, '1732552958.jpg', 15, 1, '2024-11-25 16:42:38', '2025-06-16 16:39:10', 'Select Size', 'featured', '', '11'),
(13, 'Jewelry', 3, 1, 21, NULL, NULL, NULL, 'Multi-layer Golden Necklaces', 'Multi-layer Golden Necklaces Jewely Choker Chain Vintage Necklace For Women', 400.00, 300.00, '1732553073.jpg', 90, 1, '2024-11-25 16:44:33', '2025-06-16 16:39:10', 'medium', 'featured', '', '14'),
(14, 'Men Shoes', 4, 1, 25, NULL, NULL, NULL, 'Berrykey Mens Vintage', 'Berrykey Mens Vintage Graffiti Shirts Beach Casual Official T-Shirts - Multi', 800.00, 750.00, '1732553142.jpg', 20, 1, '2024-11-25 16:45:42', '2025-06-16 16:39:10', 'Select Size', 'best_selling', '', '14'),
(15, 'Men Clothing', 4, 1, 55, NULL, NULL, NULL, 'Fashion Mens shirt', 'Fashion Mens Vintage Graffiti Short Patterned Sleeve Button-Down Hawaii Beach Shirt-Red', 1500.00, 1100.00, '1732553513.jpg', 11, 1, '2024-11-25 16:51:53', '2025-06-16 16:39:10', '', 'exclusive', '', '14'),
(16, 'Accessories', 4, 1, 7, NULL, NULL, NULL, 'Fashion 3 PCS Women Bags', 'Fashion 3 PCS Women Bags Ladies Bags Handbags Purse Shoulder Bags Tote Bags Hobo Bags\\r\\n', 1150.00, 1100.00, '1732555098.jpg', 23, 1, '2024-11-25 17:18:18', '2025-06-16 16:39:10', 'medium', 'featured', '', '11'),
(17, 'Accessories', 3, 1, 6, NULL, NULL, NULL, 'Fashion 4 PCS Women Bags', 'Fashion 4 PCS Women Bags Ladies Bags Handbags Purse Shoulder Bags Tote Bags Hobo Bags', 1700.00, 1400.00, '1732555217.jpg', 25, 1, '2024-11-25 17:20:17', '2025-06-16 16:39:10', 'large', 'featured', '', '11'),
(18, 'Women Clothing', 4, 1, 8, NULL, NULL, NULL, 'Shinny Black Flora', 'Fashion Beautiful Shinny Black Floral Shades Maxi Dera Dress(Size14/16/18', 699.00, 700.00, '1732555348.jpg', 120, 1, '2024-11-25 17:22:28', '2025-06-16 16:39:10', 'Select Size', 'popular', '', '8'),
(19, 'Women Clothing', 3, 1, 6, '2025-06-06 17:10:00', '2025-11-12 10:10:00', 'open', 'Wine Red', 'New Arrived Flared Sleeves Ruffles V Neck Dress Women Spring Autumn Long Sleeve A-Line Solid Sashes Mini Dresses DON', 2300.00, 2200.00, '1732555488.jpg', 25, 1, '2024-11-25 17:24:48', '2025-06-16 16:39:10', '', '', 'Select Brand', '14'),
(20, 'Accessories', 3, 1, 6, NULL, NULL, NULL, 'Jacket Windproof', 'Summer Thin Men\'s Fashionable Baseball Jacket Windproof Thin Jacket - Blue', 650.00, 600.00, '1732555581.jpg', 230, 1, '2024-11-25 17:26:21', '2025-06-16 16:39:10', 'large', 'popular', '', '8'),
(21, 'Accessories', 4, 1, 5, NULL, NULL, NULL, 'Male Calendar Watch', 'Fashion Large Dial Retro Trendy Male Calendar Watch Sports Quartz Leather Belt Watch', 800.00, 730.00, '1732600622.jpg', 20, 1, '2024-11-26 05:57:02', '2025-06-16 16:39:10', 'medium', 'exclusive', '', '14'),
(22, 'Select Category', 2, 1, 0, NULL, NULL, NULL, 'Men sleeve denim', 'Fashion Mens Long Sleeve Denim Jacket Casual Jeans Shirts-Blue', 2000.00, 1800.00, '1732600709.jpg', 21, 1, '2024-11-26 05:58:29', '2025-06-16 16:39:10', '', '', '', '12'),
(23, 'Accessories', 4, 1, 50, '2025-06-06 17:09:00', '2026-02-18 10:11:00', 'open', 'Casual Jacket', 'ASHION Fashion Casual Baseball Sweatshirt Casual Jacket - Green/White', 1190.00, 2380.00, '1732601306.jpg', 50, 1, '2024-11-26 06:03:16', '2025-06-16 16:39:10', 'small', 'popular', 'Puma', '13'),
(24, 'Kids Wear', 3, 1, 13, NULL, NULL, NULL, 'Fashion Trousers Mens', 'Fashion Trousers Men\\\'s 2-in-1 Short Sleeved T-shirt And Pants Set - Black', 900.00, 800.00, '1732601477.jpg', 25, 1, '2024-11-26 06:11:17', '2025-06-16 16:39:10', 'Select Size', 'popular', '', '6'),
(25, 'Accessories', 4, 1, 35, NULL, NULL, NULL, 'Women Shoulder Bags', 'Fashion Women Shoulder Bags PU Leather Backpack Bag Travel Bag-Black', 1200.00, 800.00, '1732601599.jpg', 25, 1, '2024-11-26 06:13:19', '2025-06-16 16:39:10', 'medium', 'flash_sale', 'Select Brand', '7'),
(26, 'Accessories', 4, 1, 43, NULL, NULL, NULL, 'Laptop Backpack', 'EkoShay Men Oxford Laptop Backpack Back School Bags-Black', 1200.00, 800.00, '1732601668.jpg', 20, 1, '2024-11-26 06:14:28', '2025-06-16 16:39:10', '', 'new', 'Select Brand', '13'),
(27, 'Accessories', 5, 1, 14, NULL, NULL, NULL, 'Manchester United Jersey ', 'Manchester United adidas Home Jersey 2024-25\\r\\n', 1800.00, 1700.00, '1732627742.avif', 150, 1, '2024-11-26 06:22:26', '2025-06-16 16:39:10', 'medium', 'featured', 'Select Brand', '7'),
(28, 'Select Category', 3, 1, 6, NULL, NULL, NULL, 'Chelsea 24/25 Home Kit New Season', 'Chelsea 24/25 Home Kit New Season Authentic Jersey as in picture\\r\\n', 1500.00, 1400.00, '1732627302.avif', 230, 1, '2024-11-26 06:24:28', '2025-06-16 16:39:10', 'medium', 'flash_sale', 'Select Brand', '14'),
(29, 'Men Clothing', 4, 1, 6, NULL, NULL, NULL, 'Men demin Jeans', 'New Arrival High Quality 3-Pack Men\'s Denim Jeans: A Versatile And Stylish Pack Of Three Denim Jeans Designed For Men, Perfect For Casual And Semi-formal Looks. BLUE,BLACK AND GREY.', 4800.00, 4512.00, '1743057068.jpg', 15, 1, '2024-11-26 06:26:57', '2025-06-16 16:39:10', 'EU 42', 'new', 'N/A', '5'),
(30, 'Men Clothing', 4, 1, 80, NULL, NULL, NULL, 'Berrykey Mens', 'Berrykey Men\\\'s Spring Casual Slim Fit Floral Long Sleeve T Shirts Sweatshirts-Coffee', 780.00, 300.00, '1742740762.jpg', 37, 1, '2024-11-26 07:44:04', '2025-06-17 08:33:47', 'medium', 'new', 'Select Brand', 'no limit'),
(65, 'Men Clothing', 3, 1, 45, '2025-06-06 18:35:00', '2025-07-09 22:41:00', 'open', 'Loose Men\'s shirts', 'High quality Casual Loose Men\'s shirts camisas Hawaiian Printed Cotton Linen Short Sleeve shirt', 750.00, 900.00, '1743248979.jpg', 123, 1, '2025-03-29 07:26:36', '2025-06-16 16:39:10', 'EU 42', 'flash_sale', 'Select Brand', '9'),
(66, 'Men Shoes', 1, 1, 50, '2025-04-12 18:07:00', '2025-05-30 12:00:00', 'open', 'ASHION Men\'s Sandals', 'These men\'s casual sandals offer a stylish and versatile design, perfect for daily wear. Made from high-quality synthetic leather with a crocodile texture pattern, they provide a sleek and fashionable appearance without the premium cost of genuine leather. The adjustable, rotatable heel strap allows these shoes to be worn as both slippers and sandals, making them suitable for various occasions. The wear-resistant rubber sole ensures excellent grip and long-lasting durability, while the open design promotes breathability, keeping your feet cool and comfortable throughout the day.', 650.00, 700.00, '1743254809.jpg', 211, 1, '2025-03-29 07:29:26', '2025-06-16 16:39:10', 'EU 40', 'best_selling', 'GoPrimeHost', '14');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `alt_text`, `is_primary`, `created_at`, `updated_at`) VALUES
(4, 26, 'uploads/shop/prod_6841486f6c1d81.87435187.webp', 'Laptop Backpack image 1', 1, '2025-06-05 07:34:07', '2025-06-05 07:34:07'),
(9, 66, 'uploads/shop/prod_68420b7465d4e0.13949799.jpg', 'ASHION Men\'s Sandals image 1', 1, '2025-06-05 21:26:12', '2025-06-05 21:26:12'),
(10, 66, 'uploads/shop/prod_68420b74670d95.42930418.jpg', 'ASHION Men\'s Sandals image 2', 0, '2025-06-05 21:26:12', '2025-06-05 21:26:12'),
(11, 66, 'uploads/shop/prod_68420b7468aea1.00865393.jpg', 'ASHION Men\'s Sandals image 3', 0, '2025-06-05 21:26:12', '2025-06-05 21:26:12'),
(12, 65, 'uploads/shop/prod_68420c09173f82.98435581.jpg', 'Loose Men\'s shirts image 1', 1, '2025-06-05 21:28:41', '2025-06-05 21:28:41'),
(13, 65, 'uploads/shop/prod_68420c0918a951.25837858.jpg', 'Loose Men\'s shirts image 2', 0, '2025-06-05 21:28:41', '2025-06-05 21:28:41'),
(14, 65, 'uploads/shop/prod_68420c09195666.55894350.jpg', 'Loose Men\'s shirts image 3', 0, '2025-06-05 21:28:41', '2025-06-05 21:28:41'),
(15, 30, 'uploads/shop/prod_68420c61057d31.44678341.jpg', 'Berrykey Mens image 1', 1, '2025-06-05 21:30:09', '2025-06-05 21:30:09'),
(16, 30, 'uploads/shop/prod_68420c6106dfe2.39119765.jpg', 'Berrykey Mens image 2', 0, '2025-06-05 21:30:09', '2025-06-05 21:30:09'),
(17, 29, 'uploads/shop/prod_68420d51803ec5.71069050.jpg', 'Men demin Jeans image 1', 1, '2025-06-05 21:34:09', '2025-06-05 21:34:09'),
(18, 29, 'uploads/shop/prod_68420d518107f6.19240198.jpg', 'Men demin Jeans image 2', 0, '2025-06-05 21:34:09', '2025-06-05 21:34:09'),
(19, 28, 'uploads/shop/prod_68420d91b66ea5.12292854.jpg', 'Chelsea 24/25 Home Kit New Season image 1', 1, '2025-06-05 21:35:13', '2025-06-05 21:35:13'),
(20, 28, 'uploads/shop/prod_68420d91b74674.99233820.webp', 'Chelsea 24/25 Home Kit New Season image 2', 0, '2025-06-05 21:35:13', '2025-06-05 21:35:13'),
(21, 27, 'uploads/shop/prod_68420dffa61fd0.62718501.jpg', 'Manchester United Jersey  image 1', 1, '2025-06-05 21:37:03', '2025-06-05 21:37:03'),
(22, 27, 'uploads/shop/prod_68420dffa6dd67.82450331.webp', 'Manchester United Jersey  image 2', 0, '2025-06-05 21:37:03', '2025-06-05 21:37:03'),
(23, 25, 'uploads/shop/prod_68420e2bc47092.68501668.jpg', 'Women Shoulder Bags image 1', 1, '2025-06-05 21:37:47', '2025-06-05 21:37:47'),
(24, 25, 'uploads/shop/prod_68420e2bc529d3.50593079.jpg', 'Women Shoulder Bags image 2', 0, '2025-06-05 21:37:47', '2025-06-05 21:37:47'),
(25, 8, 'uploads/shop/prod_6842147e34235.webp', 'Fashion Official Laced image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(26, 8, 'uploads/shop/prod_6842147e35098.jpg', 'Fashion Official Laced image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(27, 9, 'uploads/shop/prod_6842147e36d9f.jpg', 'Fashion Men running shoes image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(28, 9, 'uploads/shop/prod_6842147e37c36.jpg', 'Fashion Men running shoes image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(29, 10, 'uploads/shop/prod_6842147e3a64c.jpg', 'Mens Berrykey Polo image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(30, 10, 'uploads/shop/prod_6842147e3b514.jpg', 'Mens Berrykey Polo image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(31, 11, 'uploads/shop/prod_6842147e3d3a6.jpg', 'Berrykey Mens Hawaiian image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(32, 11, 'uploads/shop/prod_6842147e3e0fe.jpg', 'Berrykey Mens Hawaiian image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(33, 12, 'uploads/shop/prod_6842147e45c84.jpg', 'Golden Rings Women image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(34, 12, 'uploads/shop/prod_6842147e477d6.jpg', 'Golden Rings Women image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(35, 14, 'uploads/shop/prod_6842147e4996f.jpg', 'Berrykey Mens Vintage image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(36, 14, 'uploads/shop/prod_6842147e4b017.jpg', 'Berrykey Mens Vintage image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(37, 15, 'uploads/shop/prod_6842147e4c847.jpg', 'Fashion Mens shirt image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(38, 15, 'uploads/shop/prod_6842147e4d428.jpg', 'Fashion Mens shirt image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(39, 16, 'uploads/shop/prod_6842147e4ea51.jpg', 'Fashion 3 PCS Women Bags image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(40, 16, 'uploads/shop/prod_6842147e502ab.jpg', 'Fashion 3 PCS Women Bags image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(41, 17, 'uploads/shop/prod_6842147e53d58.jpg', 'Fashion 4 PCS Women Bags image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(42, 17, 'uploads/shop/prod_6842147e54847.jpg', 'Fashion 4 PCS Women Bags image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(43, 18, 'uploads/shop/prod_6842147e55cfc.jpg', 'Shinny Black Flora image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(44, 18, 'uploads/shop/prod_6842147e56866.jpg', 'Shinny Black Flora image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(45, 19, 'uploads/shop/prod_6842147e588e2.jpg', 'Wine Red image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(46, 19, 'uploads/shop/prod_6842147e59458.jpg', 'Wine Red image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(47, 20, 'uploads/shop/prod_6842147e5b2e8.jpg', 'Jacket Windproof image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(48, 20, 'uploads/shop/prod_6842147e5c80f.jpg', 'Jacket Windproof image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(49, 21, 'uploads/shop/prod_6842147e5dd98.jpg', 'Male Calendar Watch image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(50, 21, 'uploads/shop/prod_6842147e5e973.jpg', 'Male Calendar Watch image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(51, 22, 'uploads/shop/prod_6842147e60931.jpg', 'Men sleeve denim image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(52, 22, 'uploads/shop/prod_6842147e61551.jpg', 'Men sleeve denim image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(55, 24, 'uploads/shop/prod_6842147e65abf.jpg', 'Fashion Trousers Mens image 1', 1, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(56, 24, 'uploads/shop/prod_6842147e66710.jpg', 'Fashion Trousers Mens image 2', 0, '2025-06-05 22:04:46', '2025-06-05 22:04:46'),
(57, 1, 'uploads/shop/prod_6842171ad19c4.jpg', 'MISSLAI shoes image 1', 1, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(58, 1, 'uploads/shop/prod_6842171ad27a5.jpg', 'MISSLAI shoes image 2', 0, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(59, 2, 'uploads/shop/prod_6842171ad4012.jpg', 'Basketball Shoes image 1', 1, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(60, 2, 'uploads/shop/prod_6842171ad4c6c.jpg', 'Basketball Shoes image 2', 0, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(61, 3, 'uploads/shop/prod_6842171ad619c.jpg', 'Sports Shoes image 1', 1, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(62, 3, 'uploads/shop/prod_6842171ad6c01.jpg', 'Sports Shoes image 2', 0, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(63, 4, 'uploads/shop/prod_6842171ad81b7.jpg', 'Basketball Sneakers image 1', 1, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(64, 4, 'uploads/shop/prod_6842171ad8dae.jpg', 'Basketball Sneakers image 2', 0, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(65, 5, 'uploads/shop/prod_6842171ada8cb.jpg', 'Basketball Shoes Non-Slip image 1', 1, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(66, 5, 'uploads/shop/prod_6842171adb2e8.jpg', 'Basketball Shoes Non-Slip image 2', 0, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(67, 6, 'uploads/shop/prod_6842171adc923.jpg', 'Fashion Black Laced image 1', 1, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(68, 6, 'uploads/shop/prod_6842171add42b.jpg', 'Fashion Black Laced image 2', 0, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(69, 7, 'uploads/shop/prod_6842171ade9d7.jpg', 'Fashion Official Laced image 1', 1, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(70, 7, 'uploads/shop/prod_6842171adf828.jpg', 'Fashion Official Laced image 2', 0, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(71, 13, 'uploads/shop/prod_6842171ae09ff.jpg', 'Multi-layer Golden Necklaces image 1', 1, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(72, 13, 'uploads/shop/prod_6842171ae1770.jpg', 'Multi-layer Golden Necklaces image 2', 0, '2025-06-05 22:15:54', '2025-06-05 22:15:54'),
(76, 23, 'uploads/shop/prod_6842fcf62190b1.04046058.jpg', 'Casual Jacket image 1', 1, '2025-06-06 14:36:38', '2025-06-06 14:36:38'),
(77, 23, 'uploads/shop/prod_6842fcf623e9b4.78722463.jpg', 'Casual Jacket image 2', 0, '2025-06-06 14:36:38', '2025-06-06 14:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `promocodes`
--

CREATE TABLE `promocodes` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_purchase` decimal(10,2) DEFAULT 0.00,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_count` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promocodes`
--

INSERT INTO `promocodes` (`id`, `code`, `discount_type`, `discount_value`, `min_purchase`, `max_discount`, `start_date`, `end_date`, `usage_limit`, `usage_count`, `status`, `created_at`, `updated_at`) VALUES
(9, 'SUMMER2025', 'percentage', 20.00, 500.00, 1800.00, '2025-06-17 00:00:00', '2026-06-18 00:00:00', 0, 2, 1, '2025-06-17 10:07:27', '2025-06-21 10:10:34');

-- --------------------------------------------------------

--
-- Table structure for table `promocode_usage`
--

CREATE TABLE `promocode_usage` (
  `id` int(11) NOT NULL,
  `promocode_id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promocode_usage`
--

INSERT INTO `promocode_usage` (`id`, `promocode_id`, `user_id`, `order_id`, `discount_amount`, `used_at`) VALUES
(10, 9, 14, NULL, 902.40, '2025-06-21 09:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `order_num` int(11) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag_name`, `description`, `order_num`, `status`, `created_at`, `updated_at`) VALUES
(1, 'new', '#2 eco', 2, 1, '2025-05-30 20:14:48', '2025-06-05 22:16:45'),
(2, 'best_selling', '#3 eco', 3, 1, '2025-05-30 20:14:48', '2025-06-05 22:16:45'),
(3, 'featured', '#1 eco', 1, 1, '2025-05-30 20:14:48', '2025-06-05 22:16:45'),
(4, 'popular', '#4 eco', 4, 1, '2025-05-30 20:14:48', '2025-05-30 20:14:48'),
(5, 'trending', '#5 eco', 5, 1, '2025-05-30 20:14:48', '2025-05-30 20:14:48'),
(6, 'exclusive', '#6 eco', 6, 1, '2025-05-30 20:17:09', '2025-05-30 20:17:09'),
(7, 'flash_sale', '#7 eco', 7, 1, '2025-05-30 20:17:45', '2025-05-30 20:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_as` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=User, 1=Admin, 2=Supplier',
  `user_role` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Student, 1=Admin, 2=Lecturer, 3=Super Admin',
  `profile_picture` varchar(255) DEFAULT NULL,
  `agreed_to_terms` tinyint(1) NOT NULL DEFAULT 0,
  `verify_status` tinyint(1) NOT NULL DEFAULT 0,
  `verify_token` varchar(255) DEFAULT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `is_school_student` tinyint(1) DEFAULT 0,
  `twofa_enabled` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `street_address`, `city`, `postal_code`, `additional_info`, `password`, `role_as`, `profile_picture`, `agreed_to_terms`, `created_at`, `updated_at`, `user_status`) VALUES
(3, 'Mark', 'Kinai', 'mark@gmail.com', '0111893789', '50100', 'Nairobi', 'N50100', 'fdsdf', 'e10adc3949ba59abbe56e057f20f883e', 2, '1732445429.png', 1, '2024-11-21 13:05:04', '2025-09-13 17:45:21', 'active'),
(6, 'Mark', 'Kinai', 'markkinai3@gmail.com', '0111893789', '00100', 'Nairobi', '00100', '', '$2y$10$7nM/F9PBqaHZJ9KYhDQLQOqgZP1HOgHy2ag7cqw3eqpsij/bVzifm', 1, 'DSIC.png', 0, '2024-11-24 11:03:24', '2025-04-12 12:54:49', ''),
(12, 'Mark', 'Kinai', 'mar@gmail.com', '0111893789', NULL, NULL, NULL, NULL, '$2y$10$AUjekjxMmMaWFz1Zv3.o2OAqhewF/BlQdkOwWadj0rZZ43VFE/aP2', 2, '1732451741.jpg', 0, '2024-11-24 12:35:41', '2025-03-21 08:29:37', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_attempts`
--

CREATE TABLE `password_reset_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `email_attempted` varchar(255) DEFAULT NULL,
  `attempt_time` int(11) NOT NULL,
  `attempt_type` enum('password_reset','login_failed','login_success','honeypot','database_error','invalid_email') NOT NULL,
  `success` tinyint(1) DEFAULT 0,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_devices`
--

CREATE TABLE `student_devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `device_fingerprint` varchar(255) NOT NULL,
  `device_info` text DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_used` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_access_requests`
--

CREATE TABLE `device_access_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `device_fingerprint` varchar(255) NOT NULL,
  `device_info` text DEFAULT NULL,
  `request_reason` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `processed_by` int(11) UNSIGNED DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_checkout_id` (`checkout_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_feedback_product_id` (`product_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`blog_id`,`ip_address`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `promocodes`
--
ALTER TABLE `promocodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `promocode_usage`
--
ALTER TABLE `promocode_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promocode_id` (`promocode_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `promocode_usage`
--
ALTER TABLE `promocode_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
