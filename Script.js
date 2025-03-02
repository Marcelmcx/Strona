document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".buy").forEach(button => {
        button.addEventListener("click", (event) => {
            const product = event.target.closest(".product");
            const name = product.dataset.name;
            const price = product.dataset.price;

            fetch("server.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ name, price })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Zakupiono ${name}!`);
                } else {
                    alert("Błąd podczas zakupu.");
                }
            });
        });
    });
});
