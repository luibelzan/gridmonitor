<!DOCTYPE html>
<html lang="en">








<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    {{-- BOOTSTRAP --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    {{-- TAILWIND --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdn.plot.ly/plotly-2.31.1.min.js'></script> <!-- Load plotly.js into the DOM -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    {{-- JAVASCRIPT --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> <!--icono cargando -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- ENLACE A JS GENERAL --}}
    <script src="{{ asset('js/app.js') }}"></script>









    <style>
        /* Estilo para el contenedor con scroll */
        .overflow-auto {
            max-height: calc(100vh - 80px);
        }








        @media (min-width: 1024px) {
            #panel-container {
                margin-left: auto;
                margin-right: auto;
            }
        }








        canvas {
            width: 100% !important;
            height: auto !important;
        }








        /* Define la animación */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }








            to {
                opacity: 1;
                transform: translateY(0);
            }
        }








        /* Aplica la animación a los elementos */
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }








        /* Define una regla de CSS para escalar los elementos al pasar el ratón por encima */
        .table-cell:hover {
            transform: scale(1.1);
            /* Escala del 110% */
            transition: transform 0.2s ease;
            /* Añade una transición suave */
        }








        /* Estilo para el enlace cuando el mouse está encima */
        .nav-link:hover {
            color: rgb(88, 226, 194);
        }








        * {
            box-sizing: border-box;
        }








        .container {
            max-width: 100%;
        }








        .nav {
            display: inline-flex;
            position: relative;
            overflow: hidden;
            max-width: 100%;
            background-color: rgb(27, 32, 38);
            padding: 0 20px;
            border-radius: 40px;
            /* box-shadow: 0 10px 40px rgba(159, 162, 177, 0.2); */
            margin: auto;
            /* Centra horizontalmente */
        }








        .nav-item {
            color: #ffffff;
            padding: 20px;
            text-decoration: none;
            transition: .3s;
            margin: 0 6px;
            z-index: 1;
            /* font-family: 'DM Sans', sans-serif; */
            font-weight: 500;
            position: relative;
        }








        .nav-item:before {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: rgb(88, 226, 194);
            /* Cambio de color aquí */
            border-radius: 8px 8px 0 0;
            opacity: 0;
            transition: .3s;
        }








        .nav-item:not(.is-active):hover:before {
            opacity: 1;
            bottom: 0;
        }








        .nav-item.is-active:before {
            background-color: rgb(88, 226, 194);
            /* Color cuando está activo */
            opacity: 1;
            bottom: 0;
        }








        .nav-item:not(.is-active):hover {
            color: rgb(88, 226, 194);
            ;
        }








        .nav-indicator {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 4px;
            transition: .4s;
            height: 5px;
            z-index: 1;
            border-radius: 8px 8px 0 0;
        }








        @media (max-width: 600px) {
            .nav {
                flex-wrap: wrap;
                padding: 0;
                /* Elimina el padding horizontal en dispositivos móviles */
                border-radius: 2;
                /* Elimina el border-radius en dispositivos móviles */
                box-shadow: none;
                /* Elimina el box-shadow en dispositivos móviles */
            }








            .nav-item {
                flex: 1 0 40%;
                /* Mostrar en dos columnas */
                padding: 10px 0;
                /* Ajusta el padding para que se vea mejor en dispositivos móviles */
                text-align: center;
            }








            .nav-indicator {
                display: none;
                /* Oculta la barra indicadora en dispositivos móviles */
            }
        }




        /* Color al pasar el raton por encima de la fila de datos */
        .highlight-row:hover {
            background-color: rgba(88, 226, 194, 0.1);
            /* Cambia el color de fondo al pasar el ratón */
            transition: background-color 0.3s ease;
            /* Agrega una transición suave */


        }


        /* Asegura que el encabezado de la tabla esté siempre visible y por encima del contenido */
        thead th {
            position: sticky;
            top: -24px;
            background-color: rgb(27, 32, 38);
            z-index: 1;



        }

        .sort-arrow {
            margin-left: 6px;
            font-size: 12px;
            opacity: 0.7;
        }

        .sort-arrow.asc::before {
            content: "▲"; /* Flecha ascendente */
        }

        .sort-arrow.desc::before {
            content: "▼"; /* Flecha descendente */
        }

    </style>
    <script>
        function tableToExcel(tableID, worksheetName) {
            var table = document.getElementById(tableID); // Crear una tabla con los datos de la tabla HTML
            var data = "<table border='1'>";
            for (var i = 0; i < table.rows.length; i++) {
                var rowData = [];
                for (var j = 0; j < table.rows[i].cells.length; j++) {
                    rowData.push(table.rows[i].cells[j].innerText);
                }
                data += "<tr><td>" + rowData.join("</td><td>") + "</td></tr>";
            }
            data += "</table>"; // Convertir a formato Excel y descargar
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template =
                '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!-- ... --></head><body><table>{table}</table></body></html>';
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            };
            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            };
            var excelData = format(template, {
                worksheet: worksheetName,
                table: data
            }); // Crear un enlace temporal y descargar el archivo Excel
            var link = document.createElement("a");
            link.href = uri + base64(excelData);
            link.download = "exportacion_excel.xls";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
    <script>
        function tableToExcel2Cols(tableID, filename = '') {
            var tab_text = "<table border='2px'>";
            var textRange;
            var j = 0;
            var table = document.getElementById(tableID);
            for (j = 0; j < table.rows.length; j++) {
                tab_text = tab_text + table.rows[j].innerHTML + "</tr>";
                //tab_text=tab_text+"</tr>";
            }
            tab_text = tab_text + "</table>";
            var ua = window.navigator.userAgent;
            var msieEdge = ua.indexOf("Edge");
            if (msieEdge > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                txtArea1.document.open("txt/html", "replace");
                txtArea1.document.write(tab_text);
                txtArea1.document.close();
                txtArea1.focus();
                sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
            } else
                sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            return (sa);
        }
    </script>
    <script>
        function tableToExcel2(tableID, worksheetName) {
            var table = document.getElementById(tableID); // Crear una tabla con los datos de la tabla HTML
            var data = "<table border='1'>";
            for (var i = 0; i < table.rows.length; i++) {
                var rowData = [];
                for (var j = 0; j < table.rows[i].cells.length; j++) {
                    rowData.push(table.rows[i].cells[j].innerText);
                }
                data += "<tr><td>" + rowData.join("</td><td>") + "</td></tr>";
            }
            data += "</table>"; // Convertir a formato Excel y descargar
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template =
                '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!-- ... --></head><body><table>{table}</table></body></html>';
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            };
            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            };
            var excelData = format(template, {
                worksheet: worksheetName,
                table: data
            }); // Crear un enlace temporal y descargar el archivo Excel
            var link = document.createElement("a");
            link.href = uri + base64(excelData);
            link.download = "info_dashboard_ct.xls";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
    <script>
        function openModalEstadisticasCt() {
            document.getElementById('modalEstadisticasCt').classList.remove('hidden');

            // Contenedor donde irá el contenido
            const container = document.getElementById('modalCtContent');
            container.innerHTML = "<p class='text-center'>Cargando...</p>";

            // Petición AJAX
            fetch('/modal/stats-ct')
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                })
                .catch(err => {
                    container.innerHTML = "<p class='text-red-500'>Error al cargar datos</p>";
                });
        }

        function openModalRecuperacionLecturasCt() {
            document.getElementById('modalRecuperacionLecturasCt').classList.remove('hidden');

            // Contenedor donde irá el contenido
            const container = document.getElementById('modalRecuperacionContent');
            container.innerHTML = "<p class='text-center'>Cargando...</p>";

            // Petición AJAX
            fetch('/modal/recuperacion-lecturas')
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                })
                .catch(err => {
                    container.innerHTML = "<p class='text-red-500'>Error al cargar datos</p>";
                });
        }

        function closeModalEstadisticasCt() {
            document.getElementById('modalEstadisticasCt').classList.add('hidden');
        }

        function closeModalRecuperacionLecturasCt() {
            document.getElementById('modalRecuperacionLecturasCt').classList.add('hidden');
        }

    </script>

    <script>
        function openModalDesequilibriosVoltaje(id_ct) {
            document.getElementById("modalDesequilibriosVoltaje").classList.remove("hidden");

            fetch('/modal/desequilibrios-voltaje/' + id_ct)
                .then(res => res.text())
                .then(html => {
                    document.getElementById("modalDesequilibriosVoltajeContent").innerHTML = html;

                    // Ejecutar gráfico después de insertar el HTML
                    var grafico = document.getElementById('graficoDesequilibrioVoltaje');
                    if (grafico) {
                        var avg = parseFloat(grafico.dataset.avg);
                        var min = parseFloat(grafico.dataset.min);
                        var max = parseFloat(grafico.dataset.max);

                        if (avg === 0 && min === 0 && max === 0) {
                            grafico.innerHTML = "<p class='text-yellow-500 text-center'>No hay datos</p>";
                            return;
                        }

                        var color = avg <= 3 ? "rgb(76,218,19)" : "rgba(232,80,107,0.9)";
                        var data = [{
                            type: "indicator",
                            mode: "gauge",
                            value: avg,
                            gauge: { axis: { range: [min, max] }, bar: { color: color } }
                        }];

                        var layout = { 
                            paper_bgcolor: "transparent", 
                            font: { color: "white" }, 
                            margin: { t: 20, b: 20, l: 20, r: 20 },
                            annotations: [{
                                x: 0.5,        // centrar horizontal
                                y: 0.4,       // colocar debajo del gráfico (ajusta según altura)
                                text: avg + " %",
                                showarrow: false,
                                font: { size: 20, color: color }
                            }]
                         };
                        Plotly.react('graficoDesequilibrioVoltaje', data, layout);
                    }
                });
        }

        function openModalDesequilibriosCorriente(id_ct) {
            // Mostrar modal
            document.getElementById("modalDesequilibriosCorriente").classList.remove("hidden");

            // Cargar contenido vía AJAX
            fetch('/modal/desequilibrios-corriente/' + id_ct)
                .then(res => res.text())
                .then(html => {
                    document.getElementById("modalDesequilibriosCorrienteContent").innerHTML = html;

                    // Inicializar gráfico después de insertar el HTML
                    var grafico = document.getElementById('graficoDesequilibrioCorriente');
                    if (grafico) {
                        var avg = parseFloat(grafico.dataset.avg) || 0;
                        var min = parseFloat(grafico.dataset.min) || 0;
                        var max = parseFloat(grafico.dataset.max) || 0;

                        if(avg === 0 && min === 0 && max === 0){
                            grafico.innerHTML = "<p class='text-yellow-500 text-center'>No hay datos</p>";
                            return;
                        }

                        if(min === max) max = min + 1; // evitar rango cero

                        var color = avg <= 30 ? "rgb(76,218,19)" : "rgba(232,80,107,0.9)";

                        var data = [{
                            type: "indicator",
                            mode: "gauge",
                            value: avg,
                            gauge: { axis: { range: [min, max] }, bar: { color: color } }
                        }];

                        var layout = {
                            paper_bgcolor: "transparent",
                            font: { color: "white" },
                            margin: { t: 20, b: 20, l: 20, r: 20 },
                            annotations: [{
                                x: 0.5,
                                y: 0.4, // debajo del gráfico
                                text: avg + " %",
                                showarrow: false,
                                font: { size: 20, color: color }
                            }]
                        };

                        Plotly.react('graficoDesequilibrioCorriente', data, layout);
                    }
                });
        }

        function closeModalDesequilibriosVoltaje() {
            document.getElementById('modalDesequilibriosVoltaje').classList.add('hidden');
        }

        function closeModalDesequilibriosCorriente() {
            document.getElementById('modalDesequilibriosCorriente').classList.add('hidden');
        }

        </script>

        <script>

        function openModalPromedioFaseR(id_ct) {

        // Mostrar modal
        document.getElementById("modalPromedioFaseR").classList.remove("hidden");

        // Mostrar mensaje de carga
        const content = document.getElementById("modalPromedioFaseRContent");
        content.innerHTML = '<p class="text-center text-yellow-400">Cargando...</p>';

        // Petición AJAX
        fetch('/modal/promedio-fase-r/' + id_ct)
            .then(response => response.text())
            .then(html => {

                // Insertar HTML cargado
                content.innerHTML = html;

                // Ejecutar scripts internos si existen
                ejecutarScriptsDelContenido(content);

                // ==========================================
                //  RENDERIZAR GRAFICO PROMEDIO FASE R (ESTILO UNIFICADO)
                // ==========================================

                const graf = document.getElementById("graficoVoltajeProm1");
                if (!graf) return;

                // Leer valores desde el Blade
                const avg = parseFloat(graf.dataset.avg);
                const min = parseFloat(graf.dataset.min);
                const max = parseFloat(graf.dataset.max);

                if (avg === 0 && min === 0 && max === 0) {
                    graf.innerHTML = "<p class='text-yellow-500 text-center mt-4'>No hay datos</p>";
                    return;
                }

                // === MISMO SISTEMA DE COLORES QUE updateChartVoltajeProm1 ===
                function getColor(value) {
                    return value < 80 ? "rgba(232,80,107, 0.9)" : "rgba(39,47,58, 0.9)";
                }

                const color = getColor(avg);
                const textColor = color === "rgba(232,80,107, 0.9)" 
                    ? "rgba(232,80,107, 0.9)"
                    : "rgb(238,145,4)";

                // === DATA unificada ===
                const data = [{
                    type: "indicator",
                    mode: "gauge",
                    value: avg,
                    title: {
                        font: {
                            size: 20,
                            color: 'white'
                        }
                    },
                    gauge: {
                        axis: {
                            range: [min, max],
                            tickwidth: 1,
                            tickcolor: "rgb(238,145,4)",
                            linecolor: "rgb(238,145,4)"
                        },
                        bar: {
                            color: "rgb(238,145,4)",
                            thickness: 0.8
                        },
                        bgcolor: "transparent",
                        borderwidth: 2,
                        bordercolor: "transparent",
                        steps: [
                            { range: [0, min], color: color },
                            { range: [min, max], color: "rgba(27,32,38,0.5)" }
                        ],
                        startangle: 270
                    }
                }];

                // === LAYOUT unificado ===
                const layout = {
                    paper_bgcolor: "transparent",
                    responsive: true,
                    maintainAspectRatio: false,
                    margin: { t: 35, r: 35, l: 35, b: 35 },
                    font: {
                        color: "white",
                        family: "Didact Gothic",
                        weight: 'normal'
                    },
                    annotations: [{
                        text: avg + " V",
                        x: 0.5,
                        y: 0.4,
                        showarrow: false,
                        font: {
                            size: 20,
                            color: textColor
                        }
                    }]
                };

                // Renderizar con los MISMO estilos
                Plotly.react("graficoVoltajeProm1", data, layout, {
                    displaylogo: false,
                    displayModeBar: false
                });
            })
            .catch(error => {
                content.innerHTML = '<p class="text-center text-red-400">Error al cargar los datos</p>';
                console.error(error);
            });
    }

    function openModalPromedioFaseS(id_ct) {

        // Mostrar modal
        document.getElementById("modalPromedioFaseS").classList.remove("hidden");

        // Mostrar mensaje de carga
        const content = document.getElementById("modalPromedioFaseSContent");
        content.innerHTML = '<p class="text-center text-yellow-400">Cargando...</p>';

        // Petición AJAX
        fetch('/modal/promedio-fase-s/' + id_ct)
            .then(response => response.text())
            .then(html => {

                // Insertar HTML cargado
                content.innerHTML = html;

                // Ejecutar scripts internos si existen
                ejecutarScriptsDelContenido(content);

                // ==========================================
                //  RENDERIZAR GRAFICO PROMEDIO FASE S (ESTILO UNIFICADO)
                // ==========================================

                const graf = document.getElementById("graficoVoltajeProm2");
                if (!graf) return;

                // Leer valores desde el Blade
                const avg = parseFloat(graf.dataset.avg);
                const min = parseFloat(graf.dataset.min);
                const max = parseFloat(graf.dataset.max);
                console.log({avg, min, max}); // Esto te permitirá ver qué valores llegan realmente

                if (avg === 0 && min === 0 && max === 0) {
                    graf.innerHTML = "<p class='text-yellow-500 text-center mt-4'>No hay datos</p>";
                    return;
                }

                // === MISMO SISTEMA DE COLORES QUE FASE R PERO CELSTE ===
                function getColor(value) {
                    return value < 80 ? "rgba(232,80,107, 0.9)" : "rgba(39,47,58, 0.9)";
                }

                const color = getColor(avg);
                const textColor = color === "rgba(232,80,107, 0.9)" 
                    ? "rgba(232,80,107, 0.9)"
                    : "rgba(88,226,194,0.9)";

                // === DATA ===
                const data = [{
                    type: "indicator",
                    mode: "gauge",
                    value: avg,
                    title: {
                        font: {
                            size: 20,
                            color: 'white'
                        }
                    },
                    gauge: {
                        axis: {
                            range: [min, max],
                            tickwidth: 1,
                            tickcolor: "rgb(88,226,194)",
                            linecolor: "rgb(88,226,194)"
                        },
                        bar: {
                            color: "rgba(88,226,194,0.9)",
                            thickness: 0.8
                        },
                        bgcolor: "transparent",
                        borderwidth: 2,
                        bordercolor: "transparent",
                        steps: [
                            { range: [0, min], color: color },
                            { range: [min, max], color: "rgba(27,32,38,0.5)" }
                        ],
                        startangle: 270
                    }
                }];

                // === LAYOUT ===
                const layout = {
                    paper_bgcolor: "transparent",
                    responsive: true,
                    maintainAspectRatio: false,
                    margin: { t: 35, r: 35, l: 35, b: 35 },
                    font: {
                        color: "white",
                        family: "Didact Gothic",
                        weight: 'normal'
                    },
                    annotations: [{
                        text: avg + " V",
                        x: 0.5,
                        y: 0.4,
                        showarrow: false,
                        font: {
                            size: 20,
                            color: textColor
                        }
                    }]
                };

                // Renderizar
                Plotly.react("graficoVoltajeProm2", data, layout, {
                    displaylogo: false,
                    displayModeBar: false
                });

            })
            .catch(error => {
                content.innerHTML = '<p class="text-center text-red-400">Error al cargar los datos</p>';
                console.error(error);
            });
    }

    function openModalPromedioFaseT(id_ct) {

        // Mostrar modal
        document.getElementById("modalPromedioFaseT").classList.remove("hidden");

        // Mostrar mensaje de carga
        const content = document.getElementById("modalPromedioFaseTContent");
        content.innerHTML = '<p class="text-center text-yellow-400">Cargando...</p>';

        // Petición AJAX
        fetch('/modal/promedio-fase-t/' + id_ct)
            .then(response => response.text())
            .then(html => {

                // Insertar HTML cargado
                content.innerHTML = html;

                // Ejecutar scripts internos si existen
                ejecutarScriptsDelContenido(content);

                // ==========================================
                //  RENDERIZAR GRAFICO PROMEDIO FASE T (ESTILO UNIFICADO)
                // ==========================================

                const graf = document.getElementById("graficoVoltajeProm3");
                if (!graf) return;

                // Leer valores desde el Blade
                const avg = parseFloat(graf.dataset.avg);
                const min = parseFloat(graf.dataset.min);
                const max = parseFloat(graf.dataset.max);
                console.log({avg, min, max}); // Ver qué valores llegan realmente

                if (avg === 0 && min === 0 && max === 0) {
                    graf.innerHTML = "<p class='text-yellow-500 text-center mt-4'>No hay datos</p>";
                    return;
                }

                // === MISMO SISTEMA DE COLORES QUE FASE T (AZUL) ===
                function getColor(value) {
                    return value < 80 ? "rgba(232,80,107,0.9)" : "rgba(44,131,174,0.9)";
                }

                const color = getColor(avg);
                const textColor = color === "rgba(232,80,107,0.9)" 
                    ? "rgba(232,80,107,0.9)" 
                    : "rgba(44,131,174,0.9)";

                // === DATA ===
                const data = [{
                    type: "indicator",
                    mode: "gauge",
                    value: avg,
                    title: {
                        font: {
                            size: 20,
                            color: 'white'
                        }
                    },
                    gauge: {
                        axis: {
                            range: [min, max],
                            tickwidth: 1,
                            tickcolor: "rgb(44,131,174)",
                            linecolor: "rgb(44,131,174)"
                        },
                        bar: {
                            color: "rgba(44,131,174,0.9)",
                            thickness: 0.8
                        },
                        bgcolor: "transparent",
                        borderwidth: 2,
                        bordercolor: "transparent",
                        steps: [
                            { range: [0, min], color: color },
                            { range: [min, max], color: "rgba(27,32,38,0.5)" }
                        ],
                        startangle: 270
                    }
                }];

                // === LAYOUT ===
                const layout = {
                    paper_bgcolor: "transparent",
                    responsive: true,
                    maintainAspectRatio: false,
                    margin: { t: 35, r: 35, l: 35, b: 35 },
                    font: {
                        color: "white",
                        family: "Didact Gothic",
                        weight: 'normal'
                    },
                    annotations: [{
                        text: avg + " V",
                        x: 0.5,
                        y: 0.4,
                        showarrow: false,
                        font: {
                            size: 20,
                            color: textColor
                        }
                    }]
                };

                // Renderizar
                Plotly.react("graficoVoltajeProm3", data, layout, {
                    displaylogo: false,
                    displayModeBar: false
                });

            })
            .catch(error => {
                content.innerHTML = '<p class="text-center text-red-400">Error al cargar los datos</p>';
                console.error(error);
            });
    }



    function closeModalPromedioFaseR() {
        document.getElementById("modalPromedioFaseR").classList.add("hidden");

        // 🔥 destruir gráfico si existe
        if (window.myChartLineVoltaje1) {
            myChartLineVoltaje1.destroy();
            myChartLineVoltaje1 = null;
        }
    }

    function closeModalPromedioFaseS() {
        document.getElementById("modalPromedioFaseS").classList.add("hidden");

        // 🔥 destruir gráfico si existe
        if (window.myChartLineVoltaje2) {
            myChartLineVoltaje2.destroy();
            myChartLineVoltaje2 = null;
        }
    }

    function closeModalPromedioFaseT() {
        document.getElementById("modalPromedioFaseT").classList.add("hidden");

        // 🔥 destruir gráfico si existe
        if (window.myChartLineVoltaje3) {
            myChartLineVoltaje3.destroy();
            myChartLineVoltaje3 = null;
        }
    }

    // ---------------------------------------------------------
    // 🔥 FUNCIÓN OBLIGATORIA PARA QUE SE EJECUTEN TUS GRÁFICOS
    // ---------------------------------------------------------

    function ejecutarScriptsDelContenido(elemento) {
        const scripts = elemento.getElementsByTagName("script");

        for (let i = 0; i < scripts.length; i++) {

            const nuevoScript = document.createElement("script");

            if (scripts[i].src) {
                nuevoScript.src = scripts[i].src;
            } else {
                nuevoScript.textContent = scripts[i].innerHTML;
            }

            document.body.appendChild(nuevoScript);
        }
    }

</script>



    <script>
    function sortTable(colIndex, thElement) {
        const table = document.getElementById("testTableInfoDashboardCt");
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.rows);

        // Detectar dirección actual
        let direction = thElement.getAttribute("data-sort") === "asc" ? "desc" : "asc";
        thElement.setAttribute("data-sort", direction);
        
        // Resetear todas las flechas
        document.querySelectorAll(".sort-arrow").forEach(arrow => {
            arrow.classList.remove("asc", "desc");
        });

        // Activar flecha de esta columna
        const arrow = thElement.querySelector(".sort-arrow");
        arrow.classList.add(direction);

        // Ordenar filas
        rows.sort((a, b) => {
            let valA = a.cells[colIndex].innerText.replace('%', '').trim();
            let valB = b.cells[colIndex].innerText.replace('%', '').trim();

            // Convertir a número si aplica
            if (!isNaN(valA) && !isNaN(valB)) {
                valA = parseFloat(valA);
                valB = parseFloat(valB);
            }

            return direction === "asc" ? valA > valB ? 1 : -1 : valA < valB ? 1 : -1;
        });

        // Insertar filas ordenadas
        rows.forEach(row => tbody.appendChild(row));
    }
    </script>



    <title>Inicio CT</title>
</head>


<!-- Modal -->
<div id="modalEstadisticasCt" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-gray-900 p-6 rounded-xl max-h-[90vh] overflow-y-auto w-11/12 md:w-3/4 lg:w-1/2 relative">

        <!-- BOTÓN CERRAR -->
        <button onclick="closeModalEstadisticasCt()"
            class="absolute top-2 right-3 text-white text-xl font-bold">✕</button>

        <!-- CONTENIDO CARGADO POR AJAX -->
        <div id="modalCtContent" class="text-white">
            <p class="text-center">Cargando...</p>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="modalRecuperacionLecturasCt" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-gray-900 p-6 rounded-xl max-h-[90vh] overflow-y-auto w-11/12 md:w-3/4 lg:w-1/2 relative">

        <!-- BOTÓN CERRAR -->
        <button onclick="closeModalRecuperacionLecturasCt()"
            class="absolute top-2 right-3 text-white text-xl font-bold">✕</button>

        <!-- CONTENIDO CARGADO POR AJAX -->
        <div id="modalRecuperacionContent" class="text-white">
            <p class="text-center">Cargando...</p>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="modalDesequilibriosVoltaje" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-gray-900 p-6 rounded-xl max-h-[90vh] overflow-y-auto w-11/12 md:w-3/4 lg:w-1/2 relative">

        <!-- BOTÓN CERRAR -->
        <button onclick="closeModalDesequilibriosVoltaje()"
            class="absolute top-2 right-3 text-white text-xl font-bold">✕</button>

        <!-- CONTENIDO CARGADO POR AJAX -->
        <div id="modalDesequilibriosVoltajeContent" class="text-white">
            <p class="text-center">Cargando...</p>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="modalDesequilibriosCorriente" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-gray-900 p-6 rounded-xl max-h-[90vh] overflow-y-auto w-11/12 md:w-3/4 lg:w-1/2 relative">

        <!-- BOTÓN CERRAR -->
        <button onclick="closeModalDesequilibriosCorriente()"
            class="absolute top-2 right-3 text-white text-xl font-bold">✕</button>

        <!-- CONTENIDO CARGADO POR AJAX -->
        <div id="modalDesequilibriosCorrienteContent" class="text-white">
            <p class="text-center">Cargando...</p>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="modalPromedioFaseR" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-gray-900 p-6 rounded-xl max-h-[90vh] overflow-y-auto w-11/12 md:w-3/4 lg:w-1/2 relative">

        <!-- BOTÓN CERRAR -->
        <button onclick="closeModalPromedioFaseR()"
            class="absolute top-2 right-3 text-white text-xl font-bold">✕</button>

        <!-- CONTENIDO CARGADO POR AJAX -->
        <div id="modalPromedioFaseRContent" class="text-white">
            <p class="text-center">Cargando...</p>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="modalPromedioFaseS" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-gray-900 p-6 rounded-xl max-h-[90vh] overflow-y-auto w-11/12 md:w-3/4 lg:w-1/2 relative">

        <!-- BOTÓN CERRAR -->
        <button onclick="closeModalPromedioFaseS()"
            class="absolute top-2 right-3 text-white text-xl font-bold">✕</button>

        <!-- CONTENIDO CARGADO POR AJAX -->
        <div id="modalPromedioFaseSContent" class="text-white">
            <p class="text-center">Cargando...</p>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="modalPromedioFaseT" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-gray-900 p-6 rounded-xl max-h-[90vh] overflow-y-auto w-11/12 md:w-3/4 lg:w-1/2 relative">

        <!-- BOTÓN CERRAR -->
        <button onclick="closeModalPromedioFaseT()"
            class="absolute top-2 right-3 text-white text-xl font-bold">✕</button>

        <!-- CONTENIDO CARGADO POR AJAX -->
        <div id="modalPromedioFaseTContent" class="text-white">
            <p class="text-center">Cargando...</p>
        </div>

    </div>
</div>


<body class="h-full sm:grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 justify-center "
    style="background: linear-gradient(to bottom, rgb(42,50,62), rgb(27 32 38));" id="top">
    {{-- CARGANDO --}}
    <div class="loading show">
        <div class="spin"></div>
    </div>
    {{-- BOTON SUBIR --}}
    <div class="boton-subir">
        <a href="#top">
            <svg class="h-8 w-8 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
            </svg>
            <i class="fas fa-arrow-up"></i>
        </a>
    </div>
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased text-black dark:text-white ">
        @include('includes/header')
        <div class="lg:flex lg:ml-40 md:ml-56 sm:ml-14 ">
            <div class="lg:ml-14 p-2 mt-0 w-full"> <!-- Añadir margen superior -->
                <!-- Content -->
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14 ">
                    {{-- Botones de arriba --}}
                    {{-- CUERPO AQUI --}}
                    <h1 class="text-center text-3xl w-full" style="color: white;">DASHBOARD</h1>
                    <div
                        style="border-bottom: 3px solid transparent;
                    border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                    </div>
                    <div class="container ">
                        {{-- PRIMERA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                            {{-- 1º cuadro --}}
                            <div class="card text-white  mb-2"
                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    TRAFOS
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Número de trafos</h2>
                                                <p class="mt-4 text-3xl text-center"
                                                    style="color:rgb(88,226,194); display: flex; justify-content: center; align-items: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40"
                                                        height="40" viewBox="0 0 24 24" style="margin-right: 10px;">
                                                        <path fill="rgb(88,226,194)"
                                                            d="M6 3a2 2 0 0 0-2 2v11h2v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h6v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h2V5a2 2 0 0 0-2-2zm6 4V5h6v2zm0 2h6v2h-6zM8 5v4h2l-3 6v-4H5zm14 15v2H2v-2z" />
                                                    </svg>
                                                    {{ count($resultadosQ1dashboard) > 0 && !empty($resultadosQ1dashboard[0]->nro_trafos) ? $resultadosQ1dashboard[0]->nro_trafos : '0' }}
                                                    {{-- <img src="../../images/transformador.png" style="height: 50px; width: 50px; vertical-align: middle; margin-left: 10px;"> --}}


                                                </p>








                                            </div>
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Capacidad instalada</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ1dashboard) > 0 && !empty($resultadosQ1dashboard[0]->cap_kva) ? $resultadosQ1dashboard[0]->cap_kva : '0' }}
                                                    KVA
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- 2º cuadro --}}
                            <div class="card text-white  mb-2"
                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    CUPS / CONTADORES
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col ">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Número de Cups</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ2dashboard) > 0 && !empty($resultadosQ2dashboard[0]->nro_cups) ? $resultadosQ2dashboard[0]->nro_cups : '0' }}
                                                </p>
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Número de Autoconsumos</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ22dashboard) > 0 && !empty($resultadosQ22dashboard[0]->nro_cups) ? $resultadosQ22dashboard[0]->nro_cups : '0' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Contadores PRIME</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ3dashboard) > 0 && !empty($resultadosQ3dashboard[0]->contadores_prime) ? $resultadosQ3dashboard[0]->contadores_prime : '0' }}
                                                </p>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Otros</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ4dashboard) > 0 && !empty($resultadosQ4dashboard[0]->contadores_otros) ? $resultadosQ4dashboard[0]->contadores_otros : '0' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- 3º cuadro --}}
                            <div class="card text-white  mb-2"
                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    LECTURAS / PLC</h1> {{-- rgb(76,218,19 --}}
                                <h2 class="text-center text-1xl" style="color: white;"> AL
                                    {{ count($resultadosQ6dashboard) > 0 && !empty($resultadosQ6dashboard[0]->fecha) ? $resultadosQ6dashboard[0]->fecha : '' }}
                                </h2>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">% Contadores Activos</h2>
                                                @php
                                                    $color = 'rgb(222,54,63)'; // Rojo por defecto
                                                    $por_contadores_activos =
                                                        count($resultadosQ5dashboard) > 0 &&
                                                        !empty($resultadosQ5dashboard[0]->por_contadores_activos)
                                                            ? $resultadosQ5dashboard[0]->por_contadores_activos
                                                            : 0;
                                                    if ($por_contadores_activos >= 80 && $por_contadores_activos < 95) {
                                                        $color = 'rgb(255,155,0)'; // Naranja
                                                    } elseif ($por_contadores_activos >= 95) {
                                                        $color = 'rgb(76,218,19)'; // Verde
                                                    }
                                                @endphp <p class="mt-4 text-3xl text-center"
                                                    style="color:{{ $color }}; display: flex; justify-content: center; align-items: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40"
                                                        height="40" viewBox="0 0 20 20" style="margin-right: 10px;">
                                                        <path fill="{{ $color }}"
                                                            d="M5 2a2 2 0 0 0-2 2v5.6a5.5 5.5 0 0 1 1-.393V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2.6a5.5 5.5 0 0 1-.657 1H13a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm0 3.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zM6 6v1h6V6zm10 0h.5a.5.5 0 0 1 .5.5V8a.5.5 0 0 1-.5.5H16zm0 3.5h.5a.5.5 0 0 1 .5.5v1.5a.5.5 0 0 1-.5.5H16zm0 3.5h.5a.5.5 0 0 1 .5.5V15a.5.5 0 0 1-.5.5H16zm-6 1.5a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0m-5.631.84c.16 0 .28.15.243.307l-.238 1.006c-.063.269.243.46.435.27l2.565-2.53c.262-.259.089-.723-.27-.723h-.236a.25.25 0 0 1-.239-.325l.309-.979c.057-.18-.07-.366-.25-.366H4.86a.26.26 0 0 0-.243.171l-1.096 2.783c-.073.184.055.386.242.386z" />
                                                    </svg> {{ $por_contadores_activos }} %










                                                </p>
                                            </div>
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <div class="flex justify-around items-center mx-0 m-2 text-white">
                                                {{-- primer cuadrado --}}
                                                <div class="flex flex-col items-center ">
                                                    <h3 class="text-sm text-center font-normal mb-0">
                                                        S05</h3>
                                                    <h5 class="text-sm text-center font-normal mb-0">
                                                        <br>
                                                    </h5>
                                                    <div class="w-14 h-14 rounded-md flex justify-center items-center"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194), rgb(55, 139, 119));">
                                                        <p class="text-2xl font-bold text-white">
                                                            {{ count($resultadosQ6dashboard) > 0 && !empty($resultadosQ6dashboard[0]->lect_s05_hoy) ? $resultadosQ6dashboard[0]->lect_s05_hoy : '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- segundo cuadrado --}}
                                                <div class="flex flex-col items-center  ">
                                                    <h3 class="text-sm text-center font-normal mb-0">
                                                        S04</h3>
                                                    <h5 class="text-sm text-center font-normal mb-0">
                                                        {{ count($resultadosQ7dashboard) > 0 && !empty($resultadosQ7dashboard[0]->fec_lectura) ? $resultadosQ7dashboard[0]->fec_lectura : '0' }}
                                                    </h5>
                                                    <div class="w-14 h-14 rounded-md flex justify-center items-center"
                                                        style="background: linear-gradient(135deg,rgba(88,226,194), rgb(55, 139, 119));">
                                                        <p class="text-2xl font-bold text-white">
                                                            {{ count($resultadosQ7dashboard) > 0 && !empty($resultadosQ7dashboard[0]->lect_s04_mes) ? $resultadosQ7dashboard[0]->lect_s04_mes : '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- tercer cuadrado --}}
                                                <div class="flex flex-col items-center ">
                                                    <h3 class="text-sm text-center font-normal mb-0">
                                                        S02</h3>
                                                    <h5 class="text-sm text-center font-normal mb-0">
                                                        <br>
                                                    </h5>
                                                    <div class="w-14 h-14 rounded-md flex justify-center items-center"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194), rgb(55, 139, 119));">
                                                        <p class="text-2xl font-bold text-white">
                                                            {{ count($resultadosQ8dashboard) > 0 && !empty($resultadosQ8dashboard[0]->lect_s02_hoy) ? $resultadosQ8dashboard[0]->lect_s02_hoy : '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex justify-around items-center mx-0 m-2 text-white pt-2">
                                                    <button onclick="openModalEstadisticasCt()" title="Estadísticas CT">
                                                        <img src="/images/ctstats.png" alt="Estadísticas CT" class="w-10 h-10"></button>
                                                    <button onclick="openModalRecuperacionLecturasCt()">
                                                        <img src="/images/recuperacion.png" alt="Recuperacion Lecturas" title="Recuperacion Lecturas" class="w-10 h-10">
                                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 1º cuadro --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            <div class="card text-white  mb-2"
                                style="
                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    ESTADÍSTICAS POR C.T
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                @if (count($dashboardInfo) > 0)
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                        style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">

                                        <table id="testTableInfoDashboardCt" class="w-full text-white text-center">
                                            <thead style="border-bottom: 1px solid #ffffff;">
                                                <tr>

                                                    <th onclick="sortTable(0, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            NOMBRE CT
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(1, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Numero Trafos
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(2, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Capacidad (Kva)
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(3, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Numero Lineas
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(4, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            % Uso
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(5, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Perdida
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(6, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Porcentaje Perdida
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(7, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Desequilibrio Voltaje
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(8, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Desequilibrio Corriente
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(9, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Promedio Fase R
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(10, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Promedio Fase S
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                    <th onclick="sortTable(11, this)" class="mt-0 text-base font-bold text-center" 
                                                        style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                        <div class="flex items-center justify-center gap-1">
                                                            Promedio Fase T
                                                            <span class="sort-arrow"></span>
                                                        </div>
                                                    </th>

                                                </tr>
                                            </thead>


                                            <tbody>
                                                @foreach ($dashboardInfo as $resultado)
                                                    @php
                                                        // Obtener id_ct de forma segura
                                                        $id_ct = null;
                                                        if (is_object($resultado) && isset($resultado->id_ct)) {
                                                            $id_ct = $resultado->id_ct;
                                                        } elseif (is_array($resultado) && isset($resultado['id_ct'])) {
                                                            $id_ct = $resultado['id_ct'];
                                                        } elseif (is_string($resultado)) {
                                                            $id_ct = $resultado; // si $resultado ya es el id
                                                        }
                                                    @endphp
                                                    <tr class="highlight-row">
                                                        <td class="py-2">{{ $resultado->nombre_ct ?? 'No hay datos' }}</td>
                                                        <td class="py-2">{{ $resultado->nro_trafos ?? '0' }}</td>
                                                        <td class="py-2">{{ $resultado->capacidad_kva ?? '0' }}</td>
                                                        <td class="py-2">{{ $resultado->nro_lineas ?? '0' }}</td>
                                                        <td class="py-2"
                                                            style="color: {{ (!empty($resultado->cap_instalada) ? $resultado->cap_instalada : 0) <= 80 ? 'rgb(76,218,19)' : 'red' }};">
                                                            {{ !empty($resultado->cap_instalada) ? number_format($resultado->cap_instalada, 2) : '0' }} %
                                                        </td>

                                                        <td class="py-2">{{ $resultado->perdida ?? '0' }}</td>
                                                        <td class="py-2"
                                                            style="color: 
                                                                {{ ($resultado->porcentaje_perdida ?? 0) <= 6 ? 'rgb(76,218,19)' : 
                                                                (($resultado->porcentaje_perdida ?? 0) <= 15 ? 'yellow' : 'red') }};">
                                                            {{ $resultado->porcentaje_perdida ?? '0' }} %
                                                        </td>

                                                        <td class="py-2"
                                                            style="color: {{ ($resultado->avg_pct_deseq_voltaje ?? 0) <= 3 ? 'rgb(76,218,19)' : 'red' }};">

                                                            {{ $resultado->avg_pct_deseq_voltaje ?? '0' }} %

                                                            <!-- Botón para abrir modal -->
                                                            <button 
                                                                onclick="openModalDesequilibriosVoltaje('{{ $id_ct }}')"
                                                                class="ml-2 px-2 py-1 rounded bg-gray-700 hover:bg-gray-600 transition"
                                                                title="Ver detalles de desequilibrio">
                                                                📊
                                                            </button>


                                                        </td>

                                                        <td class="py-2"
                                                            style="color: {{ ($resultado->avg_pct_deseq_corriente ?? 0) <= 30 ? 'rgb(76,218,19)' : 'red' }};">

                                                            {{ $resultado->avg_pct_deseq_corriente ?? '0' }} %

                                                            <button 
                                                                onclick="openModalDesequilibriosCorriente('{{ $id_ct }}')"
                                                                class="ml-2 px-2 py-1 rounded bg-gray-700 hover:bg-gray-600 transition"
                                                                title="Ver detalles de desequilibrio">
                                                                📊
                                                            </button>
                                                        </td>
                                                        <td class="py-2"
                                                            style="color: 
                                                                {{ ($resultado->prom_volt1 ?? 0) <= 218 ? 'yellow' : 
                                                                (($resultado->prom_volt1 ?? 0) <= 243 ? 'rgb(76,218,19)' : 'red') }};">
                                                            {{ $resultado->prom_volt1 ?? '0' }}
                                                            <button 
                                                                onclick="openModalPromedioFaseR('{{ $id_ct }}')"
                                                                class="ml-2 px-2 py-1 rounded bg-gray-700 hover:bg-gray-600 transition"
                                                                title="Ver detalles Fase R">
                                                                📊
                                                            </button>
                                                        </td>
                                                        <td class="py-2"
                                                            style="color: 
                                                                {{ ($resultado->prom_volt2 ?? 0) <= 218 ? 'yellow' : 
                                                                (($resultado->prom_volt2 ?? 0) <= 243 ? 'rgb(76,218,19)' : 'red') }};">
                                                            {{ $resultado->prom_volt2 ?? '0' }}
                                                            <button 
                                                                onclick="openModalPromedioFaseS('{{ $id_ct }}')"
                                                                class="ml-2 px-2 py-1 rounded bg-gray-700 hover:bg-gray-600 transition"
                                                                title="Ver detalles Fase S">
                                                                📊
                                                            </button>
                                                        </td>
                                                        <td class="py-2"
                                                            style="color: 
                                                                {{ ($resultado->prom_volt3 ?? 0) <= 218 ? 'yellow' : 
                                                                (($resultado->prom_volt3 ?? 0) <= 243 ? 'rgb(76,218,19)' : 'red') }};">
                                                            {{ $resultado->prom_volt3 ?? '0' }}
                                                            <button 
                                                                onclick="openModalPromedioFaseT('{{ $id_ct }}')"
                                                                class="ml-2 px-2 py-1 rounded bg-gray-700 hover:bg-gray-600 transition"
                                                                title="Ver detalles Fase T">
                                                                📊
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                @else
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                        <p class="mt-0 text-xl text-center" style="color:rgb(88,226,194)">
                                            No hay datos
                                        </p>
                                    </div>
                                @endif

                                <div class="text-right mt-4">
                                    <input type="button"
                                        onclick="tableToExcel2('testTableInfoDashboardCt', 'W3C Example Table')"
                                        style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                </div>
                            </div>
                        </div>                         
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>



