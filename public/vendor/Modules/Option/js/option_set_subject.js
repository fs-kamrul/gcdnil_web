
let messageBox = document.getElementById('search-message');
let formBox = document.getElementById('admission_form');
let admissionForm = document.getElementById('admissionForm');
document.getElementById('searchBtn').addEventListener('click', function () {

    let studentId = document.getElementById('student_id').value.trim();
    // let searchMessage = document.getElementById('search-message');
    messageBox.innerHTML = '';
    formBox.style.display = 'none';

    if (!studentId) {
        messageBox.innerHTML = `<p class="text-danger">Please enter a Student ID.</p>`;
        return;
    }

    fetch(`/admission_search/${studentId}`)
        .then(res => res.json())
        .then(data => {
            if (data) {
                // console.log(data);
                admissionForm.action = `/admission_update/${data.id}`;
                document.getElementById('form_student_id').value = data.student_id ?? '';
                document.getElementById('su_name').value = data.name ?? '';
                document.getElementById('bl_name').value = data.bl_name ?? '';
                document.getElementById('phone_nu').value = data.phone ?? '';
                document.getElementById('father_name').value = data.father_name ?? '';
                document.getElementById('bl_father_name').value = data.bl_father_name ?? '';
                document.getElementById('father_phone').value = data.father_phone ?? '';
                document.getElementById('mother_nane').value = data.mother_nane ?? '';
                document.getElementById('bl_mother_nane').value = data.bl_mother_nane ?? '';
                document.getElementById('mother_phone').value = data.mother_phone ?? '';
                document.getElementById('dob').value = data.dob ?? '';

                document.getElementById('religion').value = data.religion ?? '';
                document.getElementById('blood_group').value = data.blood_group ?? '';
                document.getElementById('gender').value = data.gender ?? '';
                document.getElementById('nationality').value = data.nationality ?? '';
                document.getElementById('birth_registration').value = data.birth_registration ?? '';
                document.getElementById('ad_class').value = data.class ?? '';
                document.getElementById('admission_group').value = data.admission_group ?? '';
                document.getElementById('year').value = data.year ?? '';
                document.getElementById('pre_institution').value = data.pre_institution ?? '';
                document.getElementById('pre_class').value = data.pre_class ?? '';
                document.getElementById('pre_gpa').value = data.pre_gpa ?? '';
                document.getElementById('ssc_year').value = data.ssc_year ?? '';
                document.getElementById('pre_address').value = data.pre_address ?? '';
                document.getElementById('pre_postcode').value = data.pre_postcode ?? '';
                document.getElementById('pre_country').value = data.pre_country ?? '';
                document.getElementById('pre_states').value = data.pre_states ?? '';
                document.getElementById('pre_city').value = data.pre_city ?? '';
                document.getElementById('per_address').value = data.per_address ?? '';
                document.getElementById('per_postcode').value = data.per_postcode ?? '';
                document.getElementById('per_country').value = data.per_country ?? '';
                document.getElementById('per_states').value = data.per_states ?? '';
                document.getElementById('per_city').value = data.per_city ?? '';
                // document.getElementById('loc_name').value = data.loc_name ?? '';
                // document.getElementById('loc_phone').value = data.loc_phone ?? '';
                // document.getElementById('loc_relation').value = data.loc_relation ?? '';
                // document.getElementById('loc_address').value = data.loc_address ?? '';
                // document.getElementById('loc_postcode').value = data.loc_postcode ?? '';
                // document.getElementById('form_student_phone').value = data.phone ?? '';
                // console.log('success');
                formBox.style.display = 'block';
            } else {
                formBox.style.display = 'none';
                messageBox.innerHTML = `<p class="text-danger">No student found with that ID.</p>`;
            }
        })
        .catch(() => {
            // console.log('Error');
            formBox.style.display = 'none';
            messageBox.innerHTML = `<p class="text-danger">Error searching student.</p>`;
        });
});
document.getElementById('sameAsPresent').addEventListener('change', function () {
    if (this.checked) {
        // Copy text inputs
        document.getElementById('per_address').value = document.getElementById('pre_address').value;
        document.getElementById('per_postcode').value = document.getElementById('pre_postcode').value;

        // Copy selects (country, states, city)
        document.getElementById('per_country').value = document.getElementById('pre_country').value;
        document.getElementById('per_states').value = document.getElementById('pre_states').value;
        document.getElementById('per_city').value = document.getElementById('pre_city').value;
    } else {
        // Clear permanent address fields when unchecked
        document.getElementById('per_address').value = '';
        document.getElementById('per_postcode').value = '';
        document.getElementById('per_country').value = '';
        document.getElementById('per_states').value = '';
        document.getElementById('per_city').value = '';
    }
});

admissionForm.addEventListener('submit', function (e) {
    e.preventDefault();

    // Clear old messages
    messageBox.innerHTML = '';
    document.querySelectorAll('.form-control').forEach(el => {
        el.classList.remove('is-invalid');
    });
    document.querySelectorAll('.invalid-feedback').forEach(el => {
        el.textContent = '';
    });

    let formData = new FormData(admissionForm);
    // console.log(formData);

    // console.log(admissionForm.action);
    fetch(admissionForm.action, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
        },
        body: formData
    })
        .then(async res => {
            // console.log(res.ok);
            // console.log(res.status);
            if (res.status === 422) {
                let errors = await res.json();
                Object.keys(errors.errors).forEach(field => {
                    let input = document.querySelector(`[name="${field}"]`);
                    let errorDiv = document.getElementById(`error-${field}`);
                    if (input) input.classList.add('is-invalid');
                    if (errorDiv) errorDiv.textContent = errors.errors[field][0];
                });
            } else if (res.ok) {
                let data = await res.json();
                // console.log(data);
                if(data.status){
                    // kamruldashboard.showSuccess(data.message);
                    messageBox.innerHTML = `<p class="text-success">${data.message}</p>`;
                    window.location.href = `/admission_payment/${data.id}`;
                }else{
                    messageBox.innerHTML = `<p class="text-success">${data.message}</p>`;
                    // kamruldashboard.showError(data.message);
                }
                messageBox.innerHTML = `<p class="text-success">Admission updated successfully.</p>`;
            } else {
                messageBox.innerHTML = `<p class="text-danger">Something went wrong.</p>`;
            }
        });
});

let classSelect = document.getElementById('ad_class');
let groupSelect = document.getElementById('admission_group');
let container = document.getElementById('subjects-container');

function loadSubjects() {
    let classId = classSelect.value;
    let groupId = groupSelect.value;

    container.innerHTML = ''; // Clear old content

    // Only fetch if both are selected
    if (!classId || !groupId) return;

    fetch(`/get-set-subjects/${classId}/${groupId}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(set => {
                let setTitle = document.createElement('h5');
                setTitle.textContent = `${set.set_name} (Select up to ${set.selected_subject_num})`;
                container.appendChild(setTitle);

                let checkboxGroup = document.createElement('div');
                checkboxGroup.classList.add('d-flex', 'flex-wrap', 'mb-3', 'gap-3');

                Object.entries(set.subjects).forEach(([subjectId, subjectName]) => {
                    let formCheck = document.createElement('div');
                    formCheck.classList.add('form-check', 'form-check-inline');

                    let inputId = `subject_${set.set_id}_${subjectId}`;

                    formCheck.innerHTML = `
                    <input class="form-check-input" type="checkbox"
                           name="subject_id_${set.set_id}[]"
                           id="${inputId}"
                           value="${subjectId}">
                    <label class="form-check-label" for="${inputId}">${subjectName}</label>
                `;

                    checkboxGroup.appendChild(formCheck);
                });

                // Limit selection
                checkboxGroup.addEventListener('change', function(e) {
                    let checked = checkboxGroup.querySelectorAll('input[type="checkbox"]:checked');
                    if (checked.length > set.selected_subject_num) {
                        e.target.checked = false;
                        alert(`You can select up to ${set.selected_subject_num} subjects in "${set.set_name}".`);
                    }
                });

                container.appendChild(checkboxGroup);
            });
        });

}

// Run when either select changes
classSelect.addEventListener('change', loadSubjects);
groupSelect.addEventListener('change', loadSubjects);
