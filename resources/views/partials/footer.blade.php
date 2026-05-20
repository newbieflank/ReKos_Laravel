<style>
    .footer-light {
        background-color: #0f172a; /* Premium Deep Navy/Slate */
        color: #94a3b8;
        font-size: 0.95rem;
        border-top: none; /* Removed border as contrast is strong enough */
    }
    
    .footer-light a {
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }
    
    .footer-light a:hover {
        color: #59A1FF;
    }
    
    .footer-brand-title {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: 1px;
        color: #ffffff; /* White text for dark bg */
    }
    
    .footer-brand-title span {
        color: #59A1FF;
    }
    
    .footer-section-title {
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #e2e8f0;
        margin-bottom: 1.5rem;
    }
    
    .footer-links-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    
    .footer-links-list li {
        margin-bottom: 0.85rem;
    }
    
    .footer-links-list a {
        display: inline-block;
    }
    
    .footer-links-list a:hover {
        transform: translateX(4px);
    }
    
    .footer-social-icon {
        background-color: rgba(255, 255, 255, 0.05); /* Subtle glassy bg */
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #cbd5e1;
        margin-right: 10px;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        padding: 10px 20px !important;
    }
    
    .footer-social-icon:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 1.25rem;
        color: #cbd5e1; /* Brighter text for readability */
    }
    
    .footer-contact-item a {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: #cbd5e1;
    }
    
    .footer-contact-item a:hover {
        color: #59A1FF;
    }
    
    .footer-contact-icon {
        color: #59A1FF;
        font-size: 1.25rem;
        margin-top: 2px;
        flex-shrink: 0;
    }
    
    .footer-bottom {
        border-top: 1px solid #1e293b; /* Subtle dark border */
        padding: 1.5rem 0;
        font-size: 0.85rem;
    }
</style>

<footer id="contact" class="footer-light pt-5 mt-5">
    <div class="container py-4">
        <div class="row g-4">
            <!-- Column 1: Brand Info -->
            <div class="col-md-6 mb-4 mb-lg-0">
                <div class="footer-brand-title mb-3">
                    RE-KOST
                </div>
                <p class="mb-4" style="line-height: 1.6; max-width: 320px;">
                    Cari dan temukan rekomendasi kost terbaik di sekitar Bondowoso secara mudah, cepat, dan terpercaya.
                </p>
                <div class="d-flex">
                    <a href="https://wa.me/6287797552625" target="_blank" class="footer-social-icon text-decoration-none" style="width: auto; padding: 0 16px;">
                        <i class="fab fa-whatsapp me-2"></i> <span class="fw-semibold">WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Column 2: Kontak Kami -->
            <div class="col-md-6">
                <div class="footer-section-title">Kontak Kami</div>
                
                <div class="footer-contact-item">
                    <a href="https://www.google.com/maps/search/?api=1&query=Polije+Kampus+2+Bondowoso" target="_blank">
                        <i class="bi bi-geo-alt footer-contact-icon"></i>
                        <span>Polije Kampus 2 Bondowoso</span>
                    </a>
                </div>
                
                <div class="footer-contact-item">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-telephone footer-contact-icon"></i>
                        <span>+62 877-9755-2625</span>
                    </div>
                </div>
                
                <div class="footer-contact-item">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-envelope footer-contact-icon"></i>
                        <span>rekostbondowoso@gmail.com</span>
                    </div>
                </div>
                
                <div class="footer-contact-item">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-clock footer-contact-icon"></i>
                        <span>Senin – Jumat, 07:00 – 17:00 WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center text-muted">
                    &copy; {{ date('Y') }} RE-KOST. All rights reserved.
                </div>
        </div>
    </div>
</footer>
