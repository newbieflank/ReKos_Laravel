<style>
    .footer-light {
        background-color: #0f172a; 
        color: #94a3b8;
        font-size: 0.95rem;
        border-top: none; 
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
        color: #ffffff; 
    }
    
    .footer-section-title {
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #e2e8f0;
        margin-bottom: 1.5rem;
    }
    
    .footer-social-icon {
        background-color: rgba(255, 255, 255, 0.05); 
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #cbd5e1 !important;
        transition: all 0.3s ease;
        font-size: 1rem;
        padding: 10px 20px;
        text-decoration: none;
    }
    
    .footer-social-icon:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        background-color: #59A1FF;
        color: #ffffff !important;
        border-color: #59A1FF;
    }
    
    .footer-contact-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-contact-list li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }
    
    .footer-contact-list li a {
        color: #cbd5e1;
    }

    .footer-contact-list li a:hover {
        color: #59A1FF;
    }
    
    .footer-contact-icon {
        color: #59A1FF;
        font-size: 1.25rem;
        flex-shrink: 0;
        width: 30px;
        margin-top: 2px;
    }
    
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.05); 
        padding: 1.5rem 0;
        font-size: 0.85rem;
        margin-top: 2rem;
    }
</style>

<footer id="contact" class="footer-light pt-5 mt-5">
    <div class="container py-4">
        <div class="row justify-content-between g-5">
            <!-- Kolom Brand -->
            <div class="col-lg-5 col-md-6">
                <div class="footer-brand-title mb-3">
                    RE-KOST
                </div>
                <p class="mb-4" style="line-height: 1.7;">
                    Cari dan temukan rekomendasi kost terbaik di sekitar Bondowoso secara mudah, cepat, dan terpercaya. Kami hadir untuk membantu Anda mendapatkan tempat tinggal yang nyaman.
                </p>
                <a href="https://wa.me/6287797552625" target="_blank" class="footer-social-icon">
                    <i class="fab fa-whatsapp me-2 fs-5"></i> <span class="fw-semibold">Hubungi Kami</span>
                </a>
            </div>

            <!-- Kolom Kontak -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-section-title">Informasi Kontak</div>
                <ul class="footer-contact-list">
                    <li>
                        <i class="bi bi-geo-alt footer-contact-icon"></i>
                        <div>
                            <a href="https://www.google.com/maps/search/?api=1&query=Polije+Kampus+2+Bondowoso" target="_blank">
                                Polije Kampus 2 Bondowoso<br>
                                Jawa Timur, Indonesia
                            </a>
                        </div>
                    </li>
                    <li>
                        <i class="bi bi-telephone footer-contact-icon"></i>
                        <div>+62 877-9755-2625</div>
                    </li>
                    <li>
                        <i class="bi bi-envelope footer-contact-icon"></i>
                        <div>rekostbondowoso@gmail.com</div>
                    </li>
                    <li>
                        <i class="bi bi-clock footer-contact-icon"></i>
                        <div>Senin – Jumat<br>07:00 – 17:00 WIB</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center text-md-center" style="color: #cbd5e1;">
                    &copy; {{ date('Y') }} RE-KOST. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>
