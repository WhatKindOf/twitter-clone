function fetchTopbar() {
  fetch("form/topbar").then(function(response) {
    response.text().then(function(text) {
      document.querySelector(".topbar").innerHTML = text;
    });
  });
}

function fetchBlock(what) {
  if (what === "default") {
    fetch("form/signupBlock").then(function(response) {
      response.text().then(function(text) {
        document.querySelector(".signupBlock").innerHTML = text;
      });
    });
  } else if (what === "login") {
    fetch("form/login").then(function(response) {
      response.text().then(function(text) {
        document.querySelector(".signupBlock").innerHTML = text;
      });
    });
  } else if (what === "signup") {
    fetch("form/signup").then(function(response) {
      response.text().then(function(text) {
        document.querySelector(".signupBlock").innerHTML = text;
      });
    });
  }
}
