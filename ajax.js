/****************************************
 *       Basic Table                   *
 ****************************************/

$(document).ready(function () {
  $("#principal_table").DataTable();
});
$(document).ready(function () {
  $("#complain_table").DataTable();
});
$(document).ready(function () {
  $("#worker_table").DataTable();
});
$(document).ready(function () {
  $("#finished_table").DataTable();
});
$(document).ready(function () {
  $("#reassigned_table").DataTable();
});
$(document).ready(function () {
  $("#completed_table").DataTable();
});

$(document).ready(function () {
  $(".nav-link").click(function (e) {
    e.preventDefault(); // Prevent default anchor behavior
    // Remove 'active show' class from all nav links
    $(".nav-link").removeClass("active show");
    // Add 'active show' class to the clicked nav link
    $(this).addClass("active show");
    // Hide all tab panes
    $(".tab-pane").removeClass("active show");
    // Show the associated tab pane
    var target = $(this).attr("href");
    $(target).addClass("active show");
  });
});

// JS code for displaying assigned worker on priority modal box
document.querySelectorAll(".worker-option").forEach(function (element) {
  element.addEventListener("click", function () {
    var worker = this.getAttribute("data-value");
    document.getElementById("assignedWorker").textContent =
      "Assigned Worker: " + worker;
  });
});

// JS code to handle priority selection
document.querySelectorAll(".modal-body button").forEach(function (element) {
  element.addEventListener("click", function () {
    // Remove the class from all buttons
    document.querySelectorAll(".modal-body button").forEach(function (btn) {
      btn.classList.remove("selected-priority");
    });
    // Add the class to the clicked button
    this.classList.add("selected-priority");
  });
});

// JS code for getting reason from the manager when principal approval toggle is ON
document
  .getElementById("flexSwitchCheckDefault")
  .addEventListener("change", function () {
    var reasonInput = document.getElementById("reasonInput");
    if (this.checked) {
      reasonInput.style.display = "block";
    } else {
      reasonInput.style.display = "none";
    }
  });

//Jquery to pass id into accept and priority form
$(document).on("click", ".acceptcomplaint", function (e) {
  e.preventDefault();
  var user_id = $(this).val(); // Get the ID from the button's value
  console.log("User ID:", user_id);
  // Set the user_id in the hidden input field within the form
  $("#complaint_id77").val(user_id);
});

// Store selected worker value in hidden input field and update assigned worker text
document.querySelectorAll(".worker-option").forEach(function (element) {
  element.addEventListener("click", function () {
    var worker = this.getAttribute("data-value");
    document.getElementById("worker_id").value = worker;
    document.getElementById("assignedWorker").textContent =
      "Assigned Worker: " + worker;
  });
});

// Toggle reason input based on Principal Approval checkbox
document
  .getElementById("flexSwitchCheckDefault")
  .addEventListener("change", function () {
    var reasonInput = document.getElementById("reasonInput");
    if (this.checked) {
      reasonInput.style.display = "block";
    } else {
      reasonInput.style.display = "none";
    }
  });
  $(document).on("submit", "#acceptForm", function (e) {
    e.preventDefault();
    
    // Collect form data
    var formData = new FormData(this);
    formData.append("accept_complaint", true);
    
    // AJAX request to send data to the backend
    $.ajax({
      type: "POST",
      url: "testbackend.php", // Replace with your backend script URL
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        var res = jQuery.parseJSON(response);
        if (res.status == 200) {
          alert(res.message);
          
          // Close modal
          $("#prioritymodal1").modal("hide");
          
          // Reset the form
          $("#acceptForm")[0].reset();
          
          // Refresh the table body only
          $("#complain_table").load(location.href + " #complain_table");
          location.reload();
        } else if (res.status == 500) {
          alert("Something went wrong. Please try again.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        alert("Something went wrong. Please try again.");
      }
    });
  });
  

//Jquerry to pass the id into reject form
$(document).on("click", "#rejectbutton", function (e) {
  e.preventDefault();
  var user_id = $(this).val(); // Get the ID from the button's value
  console.log("User ID:", user_id);
  // Set the user_id in the hidden input field within the form
  $("#complaint_id99").val(user_id);
});
$(document).on("submit", "#rejectForm", function (e) {
  e.preventDefault();
  var formData = new FormData(this);
  formData.append("reject_complaint", true);
  
  $.ajax({
    type: "POST",
    url: "testbackend.php", // Replace with your actual backend script URL
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      var res = jQuery.parseJSON(response);
      
      if (res.status == 200) {
        // Close modal
        $("#rejectModal").modal("hide");

        // Reset the form
        $("#rejectForm")[0].reset();
        
        // Force refresh the table body with cache bypass
        $("#complain_table").load(location.href + " #complain_table > *");
        location.reload();

        alert(res.message); // Display success message
      } else if (res.status == 500) {
        $("#rejectModal").modal("hide");
        $("#rejectForm")[0].reset();
        alert("Something went wrong. Please try again.");
      }
    },
    error: function (xhr, status, error) {
      alert("An error occurred while processing your request.");
    },
  });
});


//jquerry for view complaint
$(document).on("click", ".viewcomplaint", function (e) {
  e.preventDefault();
  var user_id = $(this).val();
  console.log(user_id);
  $.ajax({
    type: "POST",
    url: "testbackend.php",
    data: {
      view_complaint: true,
      user_id: user_id,
    },
    success: function (response) {
      var res = jQuery.parseJSON(response);
      console.log(res);
      if (res.status == 500) {
        alert(res.message);
      } else {
        //$('#student_id2').val(res.data.uid);
        $("#id").val(res.data.id);
        $("#type_of_problem").text(res.data.type_of_problem);
        $("#problem_description").text(res.data.problem_description);
        $("#faculty_name").text(res.data.faculty_name);
        $("#faculty_mail").text(res.data.faculty_mail);
        $("#faculty_contact").text(res.data.faculty_contact);
        $("#block_venue").text(res.data.block_venue);
        $("#venue_name").text(res.data.venue_name);
        $("#complaintDetailsModal").modal("show");
      }
    },
  });
});

$(document).on("click", "#seeworker", function (e) {
  e.preventDefault();
  var user_id = $(this).val();
  console.log(user_id);
  $.ajax({
    type: "POST",
    url: "testbackend.php",
    data: {
      see_worker_detail: true,
      user_id: user_id,
    },
    success: function (response) {
      var res = jQuery.parseJSON(response);
      console.log(res);
      if (res.status == 500) {
        alert(res.message);
      } else {
        $("#worker_first_name").text(res.data.worker_first_name);
        $("#worker_mobile").text(res.data.worker_mobile);
        $("#worker_mail").text(res.data.worker_mail);
        $("#worker_dept").text(res.data.worker_dept);
        $("#worker_emp_type").text(res.data.worker_emp_type);
        $("#detailsModal").modal("show");
      }
    },
  });
});

//image model
// Show image
$(document).on("click", ".showImage", function () {
  var problem_id = $(this).val(); // Get the problem_id from button value
  console.log(problem_id); // Ensure this logs correctly
  $.ajax({
    type: "POST",
    url: "testbackend.php",
    data: {
      get_image: true,
      problem_id: problem_id, // Correct POST key
    },
    dataType: "json", // Automatically parses JSON responses
    success: function (response) {
      console.log(response); // Log the parsed JSON response
      if (response.status == 200) {
        // Dynamically set the image source
        $("#modalImage").attr("src", "uploads/" + response.data.images);
        // Show the modal
        $("#imageModal").modal("show");
      } else {
        // Handle case where no image is found
        alert(
          response.message || "An error occurred while retrieving the image."
        );
      }
    },
    error: function (xhr, status, error) {
      // Log the full error details for debugging
      console.error("AJAX Error: ", xhr.responseText);
      alert(
        "An error occurred: " +
          error +
          "\nStatus: " +
          status +
          "\nDetails: " +
          xhr.responseText
      );
    },
  });
});

//principal question jquerry
$(document).ready(function () {
  // When the button is clicked, populate the modal with the query
  $(".openQueryModal").on("click", function () {
    var commentQuery = $(this).data("comment-query");
    var taskId = $(this).data("task-id");
    // Set the comment query text in the modal
    $("#commentQueryText").text(commentQuery);
    // Store the task_id for later use when submitting the answer
    $("#submitReply").data("task-id", taskId);
  });

  // Handle form submission when 'Submit Reply' is clicked
  $("#submitReply").on("click", function () {
    var taskId = $(this).data("task-id");
    var commentReply = $("#commentReply").val();
    // AJAX request to send the reply to the backend
    $.ajax({
      url: "testbackend.php", // Your backend file
      type: "POST",
      data: {
        task_id: taskId,
        comment_reply: commentReply,
        submit_comment_reply: true,
      },
      success: function (response) {
        var res = jQuery.parseJSON(response);
        if (res.status == 200) {
          alert(res.message);
          $("#principalQueryModal").modal("hide");
          $("#worker_table").load(location.href + " #worker_table");
        } else {
          alert("Something went wrong. Please try again.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        alert("Something went wrong. Please try again.");
      },
    });
  });
});

$(document).on("click", ".facfeed", function (e) {
  e.preventDefault();
  var user_id = $(this).val();
  console.log(user_id);
  $.ajax({
    type: "POST",
    url: "testbackend.php",
    data: {
      facfeedview: true,
      user_id: user_id,
    },
    success: function (response) {
      var res = jQuery.parseJSON(response);
      console.log(res);
      if (res.status == 500) {
        alert(res.message);
      } else {
        //$('#student_id2').val(res.data.uid);
        $("#ffeed").val(res.data.feedback);
        $("#exampleModal").modal("show");
      }
    },
  });
});

$(document).ready(function () {
  // Open the feedback modal and set the complaintfeed ID
  $(".facfeed").click(function () {
    var complaintfeedId = $(this).val();
    $("#complaintfeed_id").val(complaintfeedId); // Store the complaintfeed ID in the hidden input
  });

  // When 'Done' is clicked
  $(".done").click(function () {
    var complaintfeedId = $("#complaintfeed_id").val(); // Get the complaintfeed ID
    updateComplaintStatus(complaintfeedId, 16); // Status '30' for Done
  });
  // When 'Reassign' is clicked
  $(".reass").click(function () {
    var complaintfeedId = $("#complaintfeed_id").val(); // Get the complaintfeed ID
    updateComplaintStatus(complaintfeedId, 15); // Status '20' for Reassign
    // Close the modal explicitly after reassign
    $("#exampleModal").modal("hide");
  });

  // Function to send AJAX request
  function updateComplaintStatus(complaintfeedId, status) {
    $.ajax({
      url: "testbackend.php", // PHP file to handle the request
      type: "POST",
      data: {
        id: complaintfeedId,
        status: status,
      },
      success: function (response) {
        // Handle the response, like showing a success message or updating the UI
        alert("Status updated successfully!");
        location.reload(); // Reload the page to see the updated status
      },
      error: function () {
        alert("Error updating status.");
      },
    });
  }
});

$(document).on("click", ".imgafter", function () {
  var problem_id = $(this).val(); // Get the problem_id from button value
  console.log(problem_id); // Ensure this logs correctly
  $.ajax({
      type: "POST",
      url: "testbackend.php",
      data: {
          get_aimage: true,
          problem2_id: problem_id, // Correct POST key
      },
      dataType: "json", // Automatically parses JSON responses
      success: function (response) {
          console.log(response); // Log the parsed JSON response
          if (response.status == 200) { // Use 'response' instead of 'res'
              // Dynamically set the image source
              $("#modalImage2").attr("src", response.data.after_photo);
              // Show the modal
              $("#afterImageModal").modal("show");
          } else {
              // Handle case where no image is found
              alert(response.message || "An error occurred while retrieving the image.");
          }
      },
      error: function(xhr, status, error) {
          console.error("AJAX Error: ", status, error);
      }
  });
});
$('#afterImageModal').on('hidden.bs.modal', function () {
  // Reset the image source to a default or blank placeholder
  $("#modalImage2").attr("src", "path/to/placeholder_image.jpg");
});