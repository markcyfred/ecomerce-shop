
<!-- Trigger Button -->
<button onclick="toggleFeedbackForm()" class="feedback-btn">💬 </button>

<!-- Slide-up Form (Bottom-Left) -->
<div id="feedbackForm" class="feedback-form-container">
     <div class="feedback-form">
          <span onclick="toggleFeedbackForm()" class="close-btn">&times;</span>
          <h4>Send Your Feedback</h4>
          <form id="feedback_ajax" enctype="multipart/form-data">
               <input type="hidden" name="submit_feedback_btn" value="1">
               <label>
                    <input type="checkbox" id="anonymousToggle" name="anonymous"> Go Anonymous
               </label>
               <input type="text" name="name" id="nameInput" placeholder="Your Name" required>
               <input type="email" name="email" id="emailInput" placeholder="Your Email" required>
               <input type="text" name="title" placeholder="Feedback Title">
               <textarea name="feedback" placeholder="Your Feedback" required></textarea>
               <input type="file" name="image" id="imageInput">
               <button type="submit">Submit</button>
          </form>

          <script>
               const anonymousToggle = document.getElementById('anonymousToggle');
               const nameInput = document.getElementById('nameInput');
               const imageInput = document.getElementById('imageInput');

               anonymousToggle.addEventListener('change', function() {
                    if (this.checked) {
                         // Fill the name with "Anonymous" and disable editing
                         nameInput.value = "Anonymous";
                         nameInput.readOnly = true;

                         // Disable the image input
                         imageInput.disabled = true;
                         imageInput.value = ""; // Clear any selected image
                    } else {
                         // Clear name field and enable editing
                         nameInput.value = "";
                         nameInput.readOnly = false;

                         // Enable the image input
                         imageInput.disabled = false;
                    }
               });
               const emailInput = document.getElementById('emailInput');

               anonymousToggle.addEventListener('change', function() {
                    if (this.checked) {
                         nameInput.value = "Anonymous";
                         nameInput.readOnly = true;

                         imageInput.disabled = true;
                         imageInput.value = "";

                         emailInput.value = "anonymous@marketplace.com";
                         emailInput.readOnly = true;
                    } else {
                         nameInput.value = "";
                         nameInput.readOnly = false;

                         imageInput.disabled = false;

                         emailInput.value = "";
                         emailInput.readOnly = false;
                    }
               });
               $('#feedback_ajax').submit(function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                         url: 'feedback_ajax.php',
                         type: 'POST',
                         data: formData,
                         contentType: false,
                         processData: false,
                         dataType: 'json',
                         success: function(response) {
                              Swal.fire({
                                   position: 'top-end',
                                   icon: response.status === 'success' ? 'success' : 'error',
                                   title: response.message,
                                   toast: true,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   width: 'auto',
                                   padding: '0.1em',
                                   background: 'white',
                                   customClass: {
                                        container: 'my-swal-container'
                                   }
                              });
                              if (response.status === 'success') {
                                   $('#feedback_ajax')[0].reset();
                              }
                         },
                         error: function(xhr, status, error) {
                              console.error(xhr.responseText);

                              Swal.fire({
                                   icon: 'error',
                                   title: 'Error!',
                                   text: 'Error adding feedback: ' + xhr.responseText,
                                   confirmButtonText: 'OK'
                              });
                         }
                    });
               });

               //feedback
          </script>


     </div>
</div>
<style>
     .feedback-btn {
          position: fixed;
          bottom: 20px;
          left: 20px;
          background-color: #007BFF;
          color: white;
          padding: 8px 14px;
          font-size: 14px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          z-index: 9999;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
     }

     .feedback-form-container {
          position: fixed;
          bottom: 60px;
          left: 20px;
          width: 300px;
          background-color: #fff;
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
          padding: 15px;
          border-radius: 10px;
          transform: translateY(200%);
          transition: transform 0.3s ease-in-out;
          z-index: 10000;
     }

     .feedback-form-container.show {
          transform: translateY(0);
     }

     .feedback-form {
          position: relative;
     }

     .feedback-form h4 {
          margin-top: 0;
          font-size: 16px;
          color: #333;
     }

     .feedback-form input,
     .feedback-form textarea {
          width: 100%;
          padding: 8px;
          margin: 8px 0;
          font-size: 13px;
          border-radius: 5px;
          border: 1px solid #ccc;
     }

     .feedback-form textarea {
          resize: vertical;
          min-height: 60px;
     }

     .feedback-form button {
          background-color: #28a745;
          color: white;
          border: none;
          padding: 8px;
          width: 100%;
          font-size: 14px;
          border-radius: 5px;
          cursor: pointer;
     }

     .feedback-form .close-btn {
          position: absolute;
          top: -10px;
          right: -10px;
          background: #dc3545;
          color: white;
          border-radius: 50%;
          padding: 0 8px;
          font-size: 18px;
          cursor: pointer;
     }
</style>
<script>
     function toggleFeedbackForm() {
          document.getElementById('feedbackForm').classList.toggle('show');
     }
</script>
