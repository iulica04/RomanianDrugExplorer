function updateYearUrl() {
    var selectedYear = document.getElementById('year-select').value;
    if (selectedYear === '') {
        return; // Dacă nu este selectat niciun an, nu face nimic
    }
    console.log('Selected year:', selectedYear);

    // Trimite cereri GET pentru fiecare tip de statistică
    ['confiscations', 'infractionality', 'emergencies', 'projects'].forEach(type => {
        var url = 'http://localhost:8080/RomanianDrugExplorer/DrugStats/' + type + '/' + selectedYear;
        console.log('Requesting data from:', url);
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                console.log('Response text:', data);
                try {
                    const jsonData = JSON.parse(data);
                    if (jsonData && jsonData.stats) {
                        if (type === 'infractionality') {
                            renderChartGenderAge(jsonData.stats, jsonData.year);
                        } else {
                            renderStats(jsonData.stats, jsonData.year, type);
                        }
                    } else {
                        console.error('Empty response or invalid data received:', jsonData);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
}


var existingChart; // Variabilă globală pentru a păstra referința la chart-ul existent

function renderChartGenderAge(stats, year) {
    var chartData = {
        labels: ["Male - Major", "Male - Minor", "Female - Major", "Female - Minor"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4", "#ffb6c1"], // Culori personalizate
            borderColor: ["#0056b3", "#6495ed", "#ff1493", "#ffa07a"], // Culori de border personalizate
            borderWidth: 1, // Grosimea borderului
            
            innerHeight: 300, // Înălțimea interioară a barelor
            outerHeight: 300, // Înălțimea exterioară a barelor
            data: [0, 0, 0, 0] // Inițializare cu zero pentru fiecare categorie
        }]
    };

    stats.forEach(stat => {
        if (stat.gen === 'barbati' && stat.varsta === 'majori') {
            chartData.datasets[0].data[0] = stat.numar;
        } else if (stat.gen === 'barbati' && stat.varsta === 'minori') {
            chartData.datasets[0].data[1] = stat.numar;
        } else if (stat.gen === 'femei' && stat.varsta === 'majori') {
            chartData.datasets[0].data[2] = stat.numar;
        } else if (stat.gen === 'femei' && stat.varsta === 'minori') {
            chartData.datasets[0].data[3] = stat.numar;
        }
    });

    var ctx = document.getElementById('infractionality-chart').getContext('2d');
   // ctx.canvas.height = 350; // Înălțimea canvas-ului
    //ctx.canvas.backgroundColor = '#f8f9fa'; // Culoarea de fundal a canvas-ului
    // Distruge chart-ul existent dacă există
    if (existingChart) {
        existingChart.destroy();
    }
    
     ctx.canvas.height = 200; // Înălțimea canvas-ului
    //ctx.canvas.backgroundColor = '#f8f9fa'; // Culoarea de fundal a canvas-ului

    existingChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)", // Culoarea grilajului
                        borderDash: [2, 2], // Linie întreruptă pentru grilaj
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333', // Culoarea textului
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                },
                x: {
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)",
                        borderDash: [2, 2],
                    },
                    title: {
                        display: true,
                        text: 'Category',
                        color: '#333',
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Related Infractionality by Gender and Age (' + year + ')',
                    color: '#000', // Culoarea titlului
                    font: {
                        family: 'Arial',
                        size: 18,
                        weight: 'bold',
                    },
                    padding: {
                        top: 10,
                        bottom: 30
                    },
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#000',
                        font: {
                            family: 'Arial',
                            size: 12,
                            weight: 'bold',
                        },
                        padding: 20,
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        family: 'Arial',
                        size: 14,
                        weight: 'bold',
                        color: '#fff',
                    },
                    bodyFont: {
                        family: 'Arial',
                        size: 12,
                        color: '#fff',
                    },
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
}



///SAVE PNG SI SVG
function saveChart(chartId, filename, format) {
    var chartCanvas = document.getElementById(chartId);
    chartCanvas.style.backgroundColor = '#f8f9fa'; // Setează culoarea de fundal a canvas-ului

    // Verifică dacă canvas-ul există
    if (existingChart) {
        // Salvează ca PNG
        if (format === 'png') {
            

            chartCanvas.toBlob(function(blob) {
                var link = document.createElement('a');
                link.download = filename + '.png';
                link.href = URL.createObjectURL(blob);
                link.click();
            });
            showSnackbar('Chart saved as PNG.', info);
        }
        // Salvează ca SVG
        else if (format === 'svg') {
            var svg = chartCanvas.cloneNode(true);
            svg.id = 'svg-' + chartId; // Adaugă un ID unic

            // Setează dimensiunile SVG-ului pentru a corespunde canvas-ului
            svg.setAttribute('width', chartCanvas.width);
            svg.setAttribute('height', chartCanvas.height);

            // Obține codul SVG
            var serializer = new XMLSerializer();
            var svgString = serializer.serializeToString(svg);

            // Creează un link pentru descărcare
            var link = document.createElement('a');
            link.download = filename + '.svg';
            link.href = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgString);
            link.click();
            showSnackbar('Chart saved as SVG.', info);

        } else {
            console.error('Unsupported format:', format);

        }
    } else {
        console.error('Canvas element not found:', chartId);
        showSnackbar('Error saving chart: Canvas is empty or not found.', error);
    }
}
