
document.addEventListener('DOMContentLoaded', function() {
    let specIndex = document.querySelectorAll('#specs-container .specs-row').length;

    document.getElementById('add-specs-btn').addEventListener('click', function() {
        const container = document.getElementById('specs-container');

        const newSpecRow = document.createElement('div');
        newSpecRow.classList.add('specs-row', 'mb-2','row');
        newSpecRow.innerHTML = `
           <div class="col-md-6">
           <input type="text" class="form-control mb-1" placeholder="Key" name="specs[${specIndex}][key]" required>
           </div>
           <div class="col-md-6">
             <input type="text" class="form-control" placeholder="Value" name="specs[${specIndex}][value]" required>
            </div>

        `;

        container.appendChild(newSpecRow);
        specIndex++;
    });

    document.getElementById('remove-specs-btn').addEventListener('click', function() {
        const container = document.getElementById('specs-container');
        const rows = container.querySelectorAll('.specs-row');

        if(rows.length > 1){
            container.removeChild(rows[rows.length - 1]);
            specIndex--;
        }
    })
});
