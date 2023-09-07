function searchFile() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("inputNameFile");
    filter = input.value.toUpperCase();
    table = document.getElementById("tableFile");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
function searchKH() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("inputMa");
    filter = input.value.toUpperCase();
    table = document.getElementById("tableKH");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "Không tồn tại";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}