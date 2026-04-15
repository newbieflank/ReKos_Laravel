<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo Re-Kost" height="70">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto fw-medium">
                <li class="nav-item px-2"><a class="nav-link active text-primary" href="#">Home</a></li>
                <li class="nav-item px-2"><a class="nav-link" href="#">Kost-an</a></li>
                <li class="nav-item px-2"><a class="nav-link" href="#">Service</a></li>
                <li class="nav-item px-2"><a class="nav-link" href="#">Contact</a></li>
            </ul>
            
            <div class="d-flex gap-2 mt-3 mt-lg-0">
                <a href="#" class="btn btn-outline-primary rounded-pill px-4 fw-medium">Sign In</a>
                <a href="#" class="btn btn-primary px-4 fw-medium text-white">Sign Up</a>
            </div>
        </div>
    </div>
</nav>