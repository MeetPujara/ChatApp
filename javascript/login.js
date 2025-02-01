const form = document.querySelector(".login form"),
	continueBtn = form.querySelector(".button input"),
	errorText = form.querySelector(".error-text");

form.onsubmit = (e) => {
	e.preventDefault();
};

continueBtn.onclick = () => {
	errorText.style.display = "none"; // Reset error message

	let xhr = new XMLHttpRequest();
	xhr.open("POST", "php/login.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE) {
			if (xhr.status === 200) {
				let data = xhr.response;
				if (data === "success") {
					localStorage.setItem("chatapp_logged_in", "true");
					localStorage.setItem("last_activity", Date.now());
					location.href = "users.php";
				} else {
					errorText.style.display = "block";
					errorText.textContent = data;
				}
			}
		}
	};
	xhr.onerror = () => {
		errorText.style.display = "block";
		errorText.textContent = "Network error occurred";
	};

	let formData = new FormData(form);
	xhr.send(formData);
};

// Session check function
function checkSession() {
	if (localStorage.getItem("chatapp_logged_in")) {
		let xhr = new XMLHttpRequest();
		xhr.open("POST", "php/check-session.php", true);
		xhr.onload = () => {
			if (xhr.readyState === XMLHttpRequest.DONE) {
				if (xhr.status === 200) {
					let data = xhr.response;
					if (data !== "valid") {
						localStorage.clear();
						location.href = "login.php";
					}
				}
			}
		};
		xhr.send();
	}
}

// Check session every minute and on page load
checkSession();
setInterval(checkSession, 60000);

// Add activity timeout
let activityTimeout;
function resetActivityTimer() {
	clearTimeout(activityTimeout);
	activityTimeout = setTimeout(() => {
		localStorage.clear();
		location.href = "login.php";
	}, 3600000); // 1 hour
}

document.addEventListener("mousemove", resetActivityTimer);
document.addEventListener("keypress", resetActivityTimer);
resetActivityTimer();
