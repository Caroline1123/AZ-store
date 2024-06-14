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
  fetch("form-validation.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      // Clear previous errors
      if (data.success) {
        window.location.href = data.redirect;
      } else {
        // Display errors
        for (let key in data.errors) {
          let errorElement = document.getElementById(key + "-error");
          if (errorElement) {
            errorElement.innerHTML = data.errors[key];
            errorElement.classList.add("alert-warning", "alert", "mt-1", "p-1");
          }
        }
      }
    })
    .catch((error) => console.error("Error:", error));
});
