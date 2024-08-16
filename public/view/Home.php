<main>
    <h1>ddd</h1>
    <form id="my-form">
        <input type="text" name="key1" />
        <input type="text" name="key2" />
        <input type="submit" name="name" />
    </form>

    <button type="button" class="btn btn-primary">Primary</button>

    <div class="alert alert-primary" role="alert">
        A simple primary alert—check it out!
    </div>

    <?= $_SERVER['REQUEST_METHOD']; ?>

    <button id="my-button" type="button" class="btn btn-primary">Click me</button>
</main>

<script>
    const form = document.getElementById('my-form');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const jsonData = JSON.stringify(data);

        console.log(jsonData);

        fetch('http://localhost/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: jsonData
            })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error(error));
    });
</script>

<script type="module">
    import { iframeRedidect } from '/lib/js/Redidect.js'

    document.getElementById('my-button').addEventListener('click', function() {
        iframeRedidect('/cosa')
    });
</script>