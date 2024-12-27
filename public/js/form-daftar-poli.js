document.getElementById("id_poli").addEventListener("change", function () {
    const poliId = this.value;
    const jadwalOptions = document.querySelectorAll("#id_jadwal option");

    // Show only options matching the selected Poli
    jadwalOptions.forEach((option) => {
        if (!poliId || option.dataset.poli === poliId) {
            option.style.display = "";
        } else {
            option.style.display = "none";
        }
    });

    // Reset the selected value of jadwal
    document.getElementById("id_jadwal").value = "";
});
