<script>
    let lineIndex = 1; // já existe a linha inicial, começa no 1
const template = document.getElementById('line-template').content;

addBtn.addEventListener('click', () => {
    const clone = document.importNode(template, true);

    // atualiza os names das linhas
    clone.querySelectorAll('select, input').forEach(input => {
        const name = input.getAttribute('name'); // ex: lines[][quantity]
        input.setAttribute('name', name.replace('[]', `[${lineIndex}]`));
    });

    clone.querySelector('.remove-line').addEventListener('click', e => {
        e.target.closest('div').remove();
    });

    linesContainer.appendChild(clone);
    lineIndex++;
});

</script>
