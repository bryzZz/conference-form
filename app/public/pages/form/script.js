const form = document.querySelector("#form"),
    formMsg = form.querySelector(".form__msg");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    // get form data
    const formData = Object.fromEntries(new FormData(e.target));
    formData["newsletter"] = formData["newsletter"] ? "yes" : "no";

    const res = await fetch("../../api/addApplication.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
    });
    const data = await res.json();

    if (data["status"] === "success") {
        formMsg.classList.remove("error");
        formMsg.textContent = "Application successfully added";
    } else {
        formMsg.classList.add("error");
        formMsg.textContent = "Something went wrong";

        console.error(data["message"]);
    }
});
