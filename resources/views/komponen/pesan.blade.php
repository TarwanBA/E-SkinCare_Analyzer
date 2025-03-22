@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            document.getElementById("success-alert").style.display = "none";
        }, 1000);
    </script>
@endif

@if (session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>

    <script>
        setTimeout(function() {
            document.getElementById("error-alert").style.display = "none";
        }, 1000);
    </script>
@endif