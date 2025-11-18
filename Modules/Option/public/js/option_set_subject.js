document.getElementById('ad_class').addEventListener('change', function () {
    let classId = this.value;
    let container = document.getElementById('subjects-container');
    container.innerHTML = ''; // Clear old content

    if (!classId) return;

    fetch(`/get-set-subjects/${classId}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(set => {
                // Set name heading
                let setTitle = document.createElement('h5');
                setTitle.textContent = set.set_name;
                container.appendChild(setTitle);

                // Subjects as radio buttons
                Object.entries(set.subjects).forEach(([subjectId, subjectName]) => {
                    let label = document.createElement('label');
                    label.style.display = 'block';
                    label.innerHTML = `
                        <input type="radio" name="subject_id" value="${subjectId}">
                        ${subjectName}
                    `;
                    container.appendChild(label);
                });
            });
        });
});
