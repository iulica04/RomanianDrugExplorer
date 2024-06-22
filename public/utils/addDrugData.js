document.getElementById('fileToUpload').addEventListener('change', function(e) {
    var fileName = e.target.files[0] ? e.target.files[0].name : null;
    if (fileName) {
        document.getElementById('fileName').textContent = "File selected: " + fileName;
    } else {
        document.getElementById('fileName').textContent = "No file selected...";
    }
});

document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var jwt = getCookie('jwt');
    console.log(jwt);
/*
    const fileInput = document.getElementById('fileToUpload');
    const file = fileInput.files[0];
    const yearSelect = document.getElementById('yearSelect').value;
    const typeSelect = document.getElementById('typeSelect').value;
    const formData = new FormData();
    formData.append('fileToUpload', file);

    fetch('http://localhost/RomanianDrugExplorer/DrugStats/add-data/' + typeSelect + '/' + yearSelect, {
        method: 'POST',
        body: formData,
        header : {
            'Content-Type': 'multipart/form-data',
        }
    })
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(({ status, body: data }) => {
            if (status === 200) {
                showSnackbar(data.message, 'info');
            } else {
                showSnackbar(data.error, 'error');
            }
    })
    .catch(error => {
        console.error('Error:', error);
    }); */
});