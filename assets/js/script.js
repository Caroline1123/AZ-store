const checkoutForm = document.querySelector("#checkout-form");
checkoutForm.addEventListener("submit", (e) => {
  e.preventDefault();
  let errors = document.querySelectorAll(".error");
  for (let error of errors) {
    error.classList.remove("alert-warning");
    error.classList.remove("alert");
    error.classList.remove("mt-1");
    error.classList.remove("p-1");
    error.innerHTML = "";
  }
  // Collect all form data into new object
  let formData = new FormData(checkoutForm);

  // Send data to PHP to handle server-side validation
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./../php/form-validation.php", true);

  // Handles validation response
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        console.log(response);
        // Response OK: form data valid after verification, display success alert
        if (!response.valid) {
          for (let key in response.errors) {
            let errorElement = document.getElementById(key + "-error");
            if (errorElement) {
              errorElement.innerHTML = response.errors[key];
              errorElement.classList.add("alert-warning");
              errorElement.classList.add("alert");
              errorElement.classList.add("mt-1");
              errorElement.classList.add("p-1");
            }
          }
        } else {
          alert("Form submitted successfully!");
          checkoutForm.reset();
        }
      } else {
        console.error("Form submission failed with status: " + xhr.status);
      }
    }
  };

  xhr.send(formData);
});
