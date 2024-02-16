const codenepal = document.querySelector(".codenepal"),
  fileInput = document.querySelector(".file-input"),
  progressArea = document.querySelector(".progress-area"),
  uploadedArea = document.querySelector(".uploaded-area");

  codenepal.addEventListener("click", () => {
  fileInput.click();
});

fileInput.onchange = ({ target }) => {
  let file = target.files[0];
  if (file) {
    let fileName = file.name;
    if (fileName.length >= 12) {
      let splitName = fileName.split('.');
      fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
    }
    simulateUpload(fileName, file);
  }
}

function simulateUpload(name, file) {
  // Simulate an upload progress bar
  let progress = 0;
  const interval = setInterval(() => {
    progress += 5; // Simulate 5% progress at each interval
    if (progress <= 100) {
      updateProgressBar(name, progress);
    } else {
      clearInterval(interval);
      showUploadedFile(name, file);
    }
  }, 200); // Simulate 200ms intervals (adjust as needed)
}

function updateProgressBar(name, progress) {
  const progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Uploading</span>
                              <span class="percent">${progress}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${progress}%"></div>
                            </div>
                          </div>
                        </li>`;
  progressArea.innerHTML = progressHTML;
}

function showUploadedFile(name, file) {
  progressArea.innerHTML = "";
  let fileSize = (file.size / (1024 * 1024)).toFixed(2) + " MB";
  let uploadedHTML = `<li class="row">
                        <div class="content upload">
                          <i class="fas fa-file-alt"></i>
                          <div class="details">
                            <span class="name">${name} • Uploaded</span>
                            <span class="size">${fileSize}</span>
                          </div>
                        </div>
                        <i class="fas fa-check"></i>
                      </li>`;
  uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
}
