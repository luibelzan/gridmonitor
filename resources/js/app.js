import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();


// DISEÑO DEL NAV
document.addEventListener("DOMContentLoaded", function () {
    const indicator = document.querySelector(".nav-indicator");
    const items = document.querySelectorAll(".nav-item");

    function handleIndicator(el) {
        items.forEach((item) => {
            item.classList.remove("is-active");
            item.removeAttribute("style");
        });

        indicator.style.width = `${el.offsetWidth}px`;
        indicator.style.left = `${el.offsetLeft}px`;
        indicator.style.backgroundColor = el.getAttribute("active-color");

        el.classList.add("is-active");
        el.style.color = el.getAttribute("active-color");
    }

    items.forEach((item) => {
        item.addEventListener("click", (e) => {
            handleIndicator(e.target);
        });
        item.classList.contains("is-active") && handleIndicator(item);
    });
});

let bar = Array.from(document.querySelectorAll("li"));

bar.forEach(function (it) {
    it.onclick = function () {
        bar.forEach(function (el) {
            el.classList.remove("active");
        });
        this.classList.toggle("active");
    };
});

// Cargando
var Loading = (loadingDelayHidden = 0) => {
    let loading = null;
    const myLoadingDelayHidden = loadingDelayHidden;
    let imgs = [];
    let lenImgs = 0;
    let counterImgsLoading = 0;

    function incrementCounterImgs() {
        counterImgsLoading += 1;
        if (counterImgsLoading === lenImgs) {
            hideLoading();
        }
    }

    function hideLoading() {
        if (loading !== null) {
            loading.classList.remove("show");
            setTimeout(function () {
                loading.remove();
            }, myLoadingDelayHidden);
        }
    }

    function init() {
        document.addEventListener("DOMContentLoaded", function () {
            loading = document.querySelector(".loading");
            imgs = Array.from(document.images);
            lenImgs = imgs.length;

            if (lenImgs === 0) {
                hideLoading();
            } else {
                imgs.forEach(function (img) {
                    img.addEventListener("load", incrementCounterImgs, false);
                    img.addEventListener("error", incrementCounterImgs, false); // Maneja imágenes que fallan al cargar
                });

                // Si todas las imágenes ya han cargado 
                imgs.forEach(function (img) {
                    if (img.complete) {
                        incrementCounterImgs();
                    }
                });
            }
        });

        window.addEventListener("load", function () {
            // Asegurarse de que se oculta el loading cuando todo el contenido ha sido completamente cargado
            hideLoading();
        });
    }

    return {
        init: init,
    };
};

Loading(1000).init();


// BOTON SUBIR
$(document).ready(function () {
    $(window).scroll(function () {
        var position = $(this).scrollTop();
        if (position > 20) {
            $(".boton-subir").fadeIn("slow");
        } else {
            $(".boton-subir").fadeOut("slow");
        }
    });
});

// FUNCION DESCARGAR EN EXCEL
    function tableToExcel(tableID, worksheetName) {
        var table = document.getElementById(tableID);
        var data = "<table border='1'>";
        for (var i = 0; i < table.rows.length; i++) {
            var rowData = [];
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                rowData.push(table.rows[i].cells[j].innerText);
            }
            data += "<tr><td>" + rowData.join("</td><td>") + "</td></tr>";
        }
        data += "</table>";
        var uri = "data:application/vnd.ms-excel;base64,";
        var template =
            '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!-- ... --></head><body><table>{table}</table></body></html>';
        var base64 = function (s) {
            return window.btoa(unescape(encodeURIComponent(s)));
        };
        var format = function (s, c) {
            return s.replace(/{(\w+)}/g, function (m, p) {
                return c[p];
            });
        };
        var excelData = format(template, {
            worksheet: worksheetName,
            table: data,
        });
        var link = document.createElement("a");
        link.href = uri + base64(excelData);
        link.download = "exportacion_excel.xls";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    // Script para hacer que se pueda hacer click en toda la fila de datos 
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener todas las filas de la tabla
            var rows = document.querySelectorAll(".highlight-row");


            // Iterar sobre todas las filas y agregar un evento de clic
            rows.forEach(function(row) {
                row.addEventListener("click", function() {
                    // Obtener el ID CUPS del enlace en la primera celda de la fila
                    var idCUPS = this.querySelector("td:first-child a").getAttribute("data-id");


                    // Redirigir a la página con el ID CUPS
                    window.location.href = "/detallesinformacioncups?id_cups=" + idCUPS;
                });
            });
        });

