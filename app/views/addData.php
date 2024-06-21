<!DOCTYPE html>
<html>
<head>
    <title>Upload Page</title>
    <link rel = "stylesheet" href="/RomanianDrugExplorer/public/styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="main">
        <h1 class="title">Upload Page</h1>

        <div class="button-row">
            <button>Confiscari Droguri</button>
            <!-- Add more buttons as needed -->
        </div>

        <div class="upload-section">
            <h2>Upload File</h2>
            <form action="/RomanianDrugExplorer/upload" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload" accept=".xlsx">
                <input type="submit" value="Upload File" name="submit">
            </form>
            <div id="drop_zone">Or drag and drop file here</div>
        </div>
    </div>

    <script>
        function handleFileSelect(evt) {
            evt.stopPropagation();
            evt.preventDefault();

            var files = evt.dataTransfer.files; // FileList object.

            // files is a FileList of File objects. List some properties.
            var output = [];
            for (var i = 0, f; f = files[i]; i++) {
                output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
                            f.size, ' bytes, last modified: ',
                            f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
                            '</li>');
            }
            document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';
        }

        function handleDragOver(evt) {
            evt.stopPropagation();
            evt.preventDefault();
            evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
        }

        // Setup the dnd listeners.
        var dropZone = document.getElementById('drop_zone');
        dropZone.addEventListener('dragover', handleDragOver, false);
        dropZone.addEventListener('drop', handleFileSelect, false);
    </script>
</body>
</html>