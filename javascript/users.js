// Add status tracking
document.addEventListener("visibilitychange", handleVisibilityChange);
window.addEventListener("beforeunload", updateStatus);

function handleVisibilityChange() {
	const status = document.hidden ? "Offline now" : "Active now";
	updateUserStatus(status);
}

function updateStatus() {
	updateUserStatus("Offline now");
}

function updateUserStatus(status) {
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "php/update-status.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.onerror = function () {
		console.error("Status update failed");
	};
	xhr.send("status=" + encodeURIComponent(status));
}

// Add periodic status check with error handling
let lastActivityTime = Date.now();
document.addEventListener("mousemove", () => (lastActivityTime = Date.now()));
document.addEventListener("keypress", () => (lastActivityTime = Date.now()));

setInterval(() => {
	if (!document.hidden) {
		const inactiveTime = Date.now() - lastActivityTime;
		if (inactiveTime < 300000) {
			// 5 minutes
			updateUserStatus("Active now");
		} else {
			updateUserStatus("Away");
		}
	}
}, 30000); // Check every 30 seconds
