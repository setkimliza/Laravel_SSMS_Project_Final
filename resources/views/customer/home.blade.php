@extends('layouts.app')

@section('title', 'FreshMart - Flavor Your Day | Neighborhood Mini Mart')

@section('styles')
<style>
    /* ========================================================
       MINDFUEL™ INSPIRED VIBRANT YELLOW HERO
       ======================================================== */
    .mindfuel-hero-container {
        background: #ffdb15;
        background: radial-gradient(circle at 68% 48%, #fff892 0%, #ffdb15 38%, #f5be0b 100%);
        border-radius: 24px;
        padding: 1.5rem 2.25rem 0.85rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 40px -10px rgba(234, 179, 8, 0.35);
        margin-bottom: 0;
    }
    
    /* Background decorative ingredients & confetti hints */
    .mindfuel-bg-decoration {
        position: absolute;
        font-size: 1.6rem;
        opacity: 0.16;
        pointer-events: none;
        user-select: none;
        z-index: 1;
    }
    .mindfuel-deco-1 { top: 12px; left: 42%; transform: rotate(15deg); }
    .mindfuel-deco-2 { bottom: 60px; left: 32%; transform: rotate(-20deg); }
    .mindfuel-deco-3 { top: 20px; right: 6%; transform: rotate(25deg); }

    .mindfuel-tag-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255, 255, 255, 0.8);
        color: #0f172a;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 0.28rem 0.8rem;
        border-radius: 9999px;
        border: 1.5px solid rgba(15, 23, 42, 0.18);
        margin-bottom: 0.55rem;
        backdrop-filter: blur(6px);
    }
    .mindfuel-hero-title {
        font-size: clamp(1.85rem, 3.2vw, 2.65rem);
        font-weight: 900;
        letter-spacing: -0.04em;
        line-height: 1.05;
        color: #0f172a;
        margin-bottom: 0.45rem;
    }
    .mindfuel-hero-desc {
        color: #1e293b;
        font-size: 0.875rem;
        line-height: 1.4;
        font-weight: 600;
        max-width: 410px;
        margin-bottom: 0.85rem;
    }
    
    /* MindFuel Buttons (Compact & balanced for screen fit) */
    .btn-mindfuel-black {
        background-color: #0f172a;
        color: #ffffff !important;
        font-weight: 800;
        font-size: 0.82rem;
        border-radius: 9999px;
        padding: 0.52rem 1.4rem;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: none;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.28);
        transition: all 0.18s ease;
    }
    .btn-mindfuel-black:hover {
        background-color: #1e293b;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.35);
    }
    .btn-mindfuel-outline {
        background-color: rgba(255, 255, 255, 0.7);
        color: #0f172a !important;
        font-weight: 800;
        font-size: 0.82rem;
        border-radius: 9999px;
        padding: 0.52rem 1.35rem;
        border: 2px solid rgba(15, 23, 42, 0.22);
        display: inline-flex;
        align-items: center;
        transition: all 0.18s ease;
        backdrop-filter: blur(6px);
    }
    .btn-mindfuel-outline:hover {
        background-color: #ffffff;
        border-color: #0f172a;
        transform: translateY(-2px);
    }

    .mindfuel-rating-row {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        font-weight: 700;
        color: #0f172a;
    }
    .mindfuel-stars {
        color: #0f172a;
        letter-spacing: 1.5px;
        font-size: 0.88rem;
    }
    .hero-delivery-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(15, 23, 42, 0.15);
        border-radius: 9999px;
        padding: 0.22rem 0.65rem;
        font-size: 0.72rem;
        font-weight: 800;
        color: #0f172a;
        backdrop-filter: blur(4px);
    }

    /* MindFuel Fanned Product Showcase - Scaled Shorter for Screen Fit */
    .mindfuel-fan-stage {
        position: relative;
        width: 100%;
        height: 265px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }
    .fan-product {
        position: absolute;
        transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1), filter 0.25s ease;
        filter: drop-shadow(0 12px 18px rgba(0, 0, 0, 0.2));
        cursor: pointer;
        user-select: none;
    }
    .fan-product:hover {
        transform: scale(1.1) translateY(-8px) !important;
        z-index: 20 !important;
        filter: drop-shadow(0 20px 28px rgba(0, 0, 0, 0.3));
    }
    .fan-product img {
        width: 100%;
        height: auto;
        object-fit: contain;
        display: block;
    }

    /* 1. Main Center: Lay's Yellow Classic Chips */
    .fan-product-center {
        width: 132px;
        z-index: 6;
        top: 8px;
        left: 34%;
        transform: rotate(-3deg);
    }
    /* 2. Left: Lay's Sour Cream & Onion (Green Bag) */
    .fan-product-left {
        width: 110px;
        z-index: 5;
        top: 22px;
        left: 9%;
        transform: rotate(-14deg);
    }
    /* 3. Right: Takis Spicy Munchies (Red/Purple Bag) */
    .fan-product-right {
        width: 120px;
        z-index: 5;
        top: 14px;
        right: 9%;
        transform: rotate(14deg);
    }
    /* 4. Upper Right: Coca-Cola Red Can */
    .fan-product-coke {
        width: 78px;
        z-index: 3;
        top: 6px;
        right: 2%;
        transform: rotate(10deg);
    }
    /* 5. Bottom Right: Milka Choco Cookies (Purple Pouch) */
    .fan-product-bottom-right {
        width: 110px;
        z-index: 7;
        bottom: 8px;
        right: 14%;
        transform: rotate(-6deg);
    }
    /* 6. Bottom Left: Kinder Bueno Chocolate Wafer Bar */
    .fan-product-bottom-left {
        width: 105px;
        z-index: 7;
        bottom: 12px;
        left: 14%;
        transform: rotate(10deg);
    }
    /* 7. Foreground Center: Pringles Can */
    .fan-product-fg {
        width: 82px;
        z-index: 8;
        bottom: 0px;
        left: 39%;
        transform: rotate(2deg);
    }

    /* Floating Snack Particles (MindFuel Ingredients Silhouette) */
    @keyframes floatParticle {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-5px) rotate(5deg); }
    }
    .snack-particle {
        position: absolute;
        pointer-events: none;
        z-index: 8;
        filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.15));
        animation: floatParticle 4s ease-in-out infinite;
        user-select: none;
    }
    .p-puff-1 { top: 16px; left: 30%; animation-delay: 0s; font-size: 1.4rem; }
    .p-chip-1 { bottom: 65px; left: 5%; animation-delay: 1.2s; font-size: 1.4rem; }
    .p-choco-1 { bottom: 20px; right: 35%; animation-delay: 2.4s; font-size: 1.35rem; }
    .p-chili-1 { top: 60px; right: 3%; animation-delay: 0.8s; font-size: 1.35rem; }
    .p-cookie-1 { bottom: 55px; right: 5%; animation-delay: 1.8s; font-size: 1.4rem; }

    /* Floating Discount Badge (Proportionate) */
    .fan-circle-badge {
        position: absolute;
        top: 8px;
        right: 12px;
        background: #0f172a;
        color: #ffffff;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 0.55rem;
        font-weight: 800;
        line-height: 1.1;
        box-shadow: 0 5px 14px rgba(0, 0, 0, 0.22);
        border: 2px dashed #facc15;
        transform: rotate(8deg);
        z-index: 12;
    }
    .fan-circle-badge span {
        font-size: 0.92rem;
        color: #facc15;
        font-weight: 900;
    }

    /* 5 Floating White Feature Pills Row (Compact) */
    .mindfuel-pills-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.55rem;
        margin-top: 0.85rem;
        position: relative;
        z-index: 3;
    }
    @media (max-width: 991.98px) {
        .mindfuel-pills-row {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 575.98px) {
        .mindfuel-pills-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .mindfuel-pill-card {
        background: #ffffff;
        border-radius: 9999px;
        padding: 0.38rem 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        font-weight: 800;
        font-size: 0.75rem;
        color: #0f172a;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }
    .mindfuel-pill-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }
    .mindfuel-pill-card i {
        font-size: 0.95rem;
        color: #eab308;
    }

    /* ========================================================
       OVERLAPPING WHITE VALUE BANNER (WARM GOLDEN ACCENT)
       ======================================================== */
    .mindfuel-overlap-strip {
        background: #ffffff;
        border-radius: 18px;
        padding: 1.15rem 1.75rem;
        box-shadow: 0 8px 24px rgba(250, 204, 21, 0.12);
        border: 1.5px solid #fde047;
        margin-top: -1rem;
        position: relative;
        z-index: 10;
        margin-bottom: 2rem;
    }
    .overlap-title {
        font-size: 1.35rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.025em;
        line-height: 1.15;
    }
    .overlap-title-sub {
        font-size: 0.8125rem;
        color: #64748b;
        font-weight: 500;
    }
    .overlap-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
    }
    .overlap-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #fef08a;
        color: #854d0e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .overlap-feat-title {
        font-size: 0.875rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
        margin-bottom: 0.15rem;
    }
    .overlap-feat-desc {
        font-size: 0.75rem;
        color: #64748b;
        line-height: 1.35;
        margin-bottom: 0;
    }

    /* ========================================================
       SHOP BY MINI MART AISLE - 7 BALANCED COLUMNS
       ======================================================== */
    .section-headline {
        font-size: 1.45rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.025em;
    }

    .real-cat-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.75rem;
    }
    @media (max-width: 1199.98px) {
        .real-cat-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    @media (max-width: 767.98px) {
        .real-cat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .real-cat-card {
        background: #ffffff;
        border: 1.5px solid var(--border-color);
        border-radius: 18px;
        padding: 1rem 0.5rem 0.85rem;
        text-align: center;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        height: 100%;
        transition: transform 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
    }
    .real-cat-card:hover {
        transform: translateY(-4px);
        border-color: #facc15;
        box-shadow: 0 12px 24px -8px rgba(250, 204, 21, 0.4);
    }
    .real-cat-img-box {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        overflow: hidden;
    }
    .real-cat-img-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.22s ease;
    }
    .real-cat-card:hover .real-cat-img-box img {
        transform: scale(1.1);
    }
    .real-cat-title {
        font-size: 0.8125rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-bottom: 0.15rem;
    }
    .real-cat-card:hover .real-cat-title {
        color: #ca8a04;
    }
    .real-cat-count {
        font-size: 0.6875rem;
        color: #94a3b8;
        font-weight: 600;
    }

    /* ========================================================
       DUAL PROMOTIONAL BANNERS (MINDFUEL STYLE)
       ======================================================== */
    .promo-banner-row {
        margin-bottom: 2.75rem;
    }
    .promo-card-saver {
        background: linear-gradient(130deg, #0f172a 0%, #1e293b 55%, #334155 100%);
        border-radius: 20px;
        color: #ffffff;
        padding: 1.75rem 2rem;
        height: 230px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(250, 204, 21, 0.2);
        border: 2px solid #facc15;
    }
    .promo-saver-content {
        position: relative;
        z-index: 2;
        max-width: 58%;
    }
    .promo-discount-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #facc15;
        color: #0f172a;
        font-weight: 800;
        font-size: 0.72rem;
        padding: 0.25rem 0.65rem;
        border-radius: 9999px;
        margin-bottom: 0.55rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .promo-saver-title {
        font-size: 1.85rem;
        font-weight: 900;
        letter-spacing: -0.025em;
        line-height: 1.1;
        margin-bottom: 0.35rem;
    }
    .promo-saver-desc {
        color: rgba(255, 255, 255, 0.82);
        font-size: 0.8125rem;
        line-height: 1.4;
        margin-bottom: 0.85rem;
        max-width: 330px;
    }
    .btn-promo-yellow-pill {
        background: #facc15;
        color: #0f172a !important;
        font-weight: 800;
        font-size: 0.8125rem;
        border-radius: 9999px;
        padding: 0.5rem 1.35rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border: none;
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.35);
        transition: transform 0.15s ease, background 0.15s ease;
    }
    .btn-promo-yellow-pill:hover {
        background: #fde047;
        transform: translateY(-2px);
    }
    .promo-saver-image {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 48%;
        height: 100%;
        object-fit: cover;
        mask-image: linear-gradient(to left, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 100%);
        -webkit-mask-image: linear-gradient(to left, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 100%);
        z-index: 1;
        pointer-events: none;
    }

    .promo-card-express {
        background: linear-gradient(135deg, #fef08a 0%, #fde047 50%, #facc15 100%);
        border: 1.5px solid #eab308;
        border-radius: 20px;
        padding: 1.75rem 1.75rem;
        height: 230px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(250, 204, 21, 0.25);
    }
    .promo-express-content {
        position: relative;
        z-index: 2;
        max-width: 58%;
    }
    .promo-express-title {
        font-size: 1.5rem;
        font-weight: 900;
        letter-spacing: -0.025em;
        line-height: 1.15;
        color: #0f172a;
        margin-bottom: 0.35rem;
    }
    .promo-express-desc {
        color: #1e293b;
        font-size: 0.8125rem;
        font-weight: 600;
        line-height: 1.35;
        margin-bottom: 0.85rem;
    }
    .btn-promo-black-pill {
        background: #0f172a;
        color: #ffffff !important;
        font-weight: 800;
        font-size: 0.8125rem;
        border-radius: 9999px;
        padding: 0.5rem 1.35rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border: none;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        transition: all 0.15s ease;
    }
    .btn-promo-black-pill:hover {
        background: #1e293b;
        transform: translateY(-2px);
    }
    .promo-express-rider-img {
        position: absolute;
        right: 8px;
        bottom: 5px;
        height: 175px;
        object-fit: contain;
        z-index: 1;
        filter: drop-shadow(0 6px 14px rgba(0,0,0,0.12));
    }

    /* ========================================================
       MINDFUEL STYLE PRODUCT CARDS (YELLOW ACCENTED)
       ======================================================== */
    .grocery-product-card {
        background: #ffffff;
        border: 1.5px solid #fef08a;
        border-radius: 18px;
        padding: 0.85rem;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }
    .grocery-product-card:hover {
        transform: translateY(-3px);
        border-color: #facc15;
        box-shadow: 0 12px 28px -6px rgba(250, 204, 21, 0.28);
    }
    .grocery-discount-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #facc15;
        color: #0f172a;
        font-size: 0.6875rem;
        font-weight: 900;
        padding: 0.22rem 0.55rem;
        border-radius: 9999px;
        z-index: 2;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    }
    .grocery-img-box {
        height: 125px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.25rem;
        margin-bottom: 0.5rem;
        background: #ffffff;
        position: relative;
    }
    .grocery-img-box img {
        max-height: 115px;
        max-width: 90%;
        object-fit: contain;
        transition: transform 0.2s ease;
    }
    .grocery-product-card:hover .grocery-img-box img {
        transform: scale(1.08);
    }
    .grocery-cat-tag {
        font-size: 0.65rem;
        font-weight: 800;
        color: #ca8a04;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.15rem;
    }
    .grocery-item-title {
        font-size: 0.875rem;
        font-weight: 800;
        color: #0f172a;
        text-decoration: none;
        line-height: 1.3;
        height: 2.3rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 0.25rem;
    }
    .grocery-item-title:hover {
        color: #ca8a04;
    }
    .grocery-rating-stars {
        color: #ca8a04;
        font-size: 0.72rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    .grocery-price-current {
        font-size: 1.15rem;
        font-weight: 900;
        color: #0f172a;
    }
    .grocery-price-orig {
        font-size: 0.75rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 0.35rem;
        font-weight: 500;
    }
    .btn-add-grocery {
        background-color: #facc15;
        color: #0f172a;
        border: none;
        font-weight: 800;
        font-size: 0.78rem;
        padding: 0.38rem 0.95rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        box-shadow: 0 2px 8px rgba(250, 204, 21, 0.35);
        transition: all 0.15s ease;
    }
    .btn-add-grocery:hover {
        background-color: #eab308;
        color: #0f172a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(234, 179, 8, 0.45);
    }

    /* Trust Assurance Boxes (Yellow Accented) */
    .assurance-box {
        background: #ffffff;
        border: 1.5px solid #fef08a;
        border-radius: 18px;
        padding: 1.25rem 1.15rem;
        height: 100%;
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        transition: transform 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
    }
    .assurance-box:hover {
        transform: translateY(-2px);
        border-color: #facc15;
        box-shadow: 0 8px 20px rgba(250, 204, 21, 0.2);
    }
    .assurance-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #fef08a;
        color: #854d0e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')
<div class="container pb-5">

    <!-- 1. Hero Section (MindFuel™ Vibrant Yellow Style) -->
    <div class="mindfuel-hero-container">
        <!-- Floating background playful silhouettes -->
        <span class="mindfuel-bg-decoration mindfuel-deco-1">🍿</span>
        <span class="mindfuel-bg-decoration mindfuel-deco-2">🧀</span>
        <span class="mindfuel-bg-decoration mindfuel-deco-3">🍫</span>

        <div class="row align-items-center g-4">
            
            <!-- Left Hero Content -->
            <div class="col-lg-6 position-relative" style="z-index: 5;">
                <div class="mindfuel-tag-pill">
                    <i class="bi bi-lightning-charge-fill text-dark"></i>
                    <span>YOUR NEIGHBORHOOD MINI MART</span>
                </div>
                <h1 class="mindfuel-hero-title">
                    Flavor<br>
                    Your Day.
                </h1>
                <p class="mindfuel-hero-desc">
                    Grab your favorite crispy snacks, ice-cold drinks, fresh bakery sweets, and daily convenience essentials with bold flavor and 30-minute delivery.
                </p>
                
                <div class="d-flex flex-wrap gap-3 mb-2">
                    <a href="{{ route('catalog') }}" class="btn-mindfuel-black">
                        <span>Shop Now</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('catalog') }}?sort=price_low" class="btn-mindfuel-outline">
                        <span>Deals & Combos 15% Off</span>
                    </a>
                </div>

                <!-- Star Rating & Delivery Social Proof -->
                <div class="d-flex flex-wrap align-items-center gap-3 mt-3">
                    <div class="mindfuel-rating-row">
                        <span class="mindfuel-stars">★★★★★</span>
                        <span>10,000+ happy neighborhood snackers</span>
                    </div>
                    <div class="hero-delivery-pill">
                        <i class="bi bi-lightning-charge-fill text-dark"></i>
                        <span>30-Min Fast Dispatch</span>
                    </div>
                </div>
            </div>

            <!-- Right Hero: MindFuel Fanned Packaged Products Display -->
            <div class="col-lg-6">
                <div class="mindfuel-fan-stage">
                    
                    <!-- Floating 30% OFF Circle Badge -->
                    <div class="fan-circle-badge">
                        UP TO
                        <span>30%</span>
                        OFF
                    </div>

                    <!-- Floating Snack Ingredients Particles -->
                    <span class="snack-particle p-puff-1" title="Cheese Puff">🧀</span>
                    <span class="snack-particle p-chip-1" title="Crispy Potato Chip">🥔</span>
                    <span class="snack-particle p-choco-1" title="Chocolate Chunk">🍫</span>
                    <span class="snack-particle p-chili-1" title="Spicy Chili">🌶️</span>
                    <span class="snack-particle p-cookie-1" title="Choco Cookie">🍪</span>

                    <!-- Fanned Packaged Products (Transparent PNGs) -->
                    <!-- 1. Upper Right: Coca-Cola Red Can -->
                    <div class="fan-product fan-product-coke" title="Coca-Cola Original 330ml Can" onclick="window.location='{{ route('catalog') }}?search=Cola';">
                        <img src="{{ asset('images/transparent/coca_cola.png') }}" alt="Coca-Cola Can">
                    </div>

                    <!-- 2. Left: Lay's Sour Cream & Onion (Green Bag) -->
                    <div class="fan-product fan-product-left" title="Lay's Sour Cream & Onion" onclick="window.location='{{ route('catalog') }}?search=Lays';">
                        <img src="{{ asset('images/transparent/lays_sour_cream.png') }}" alt="Lay's Sour Cream & Onion">
                    </div>

                    <!-- 3. Center Hero: Lay's Classic Potato Chips (Yellow Bag) -->
                    <div class="fan-product fan-product-center" title="Lay's Classic Salted Potato Chips" onclick="window.location='{{ route('catalog') }}?search=Lays';">
                        <img src="{{ asset('images/transparent/lays_classic.png') }}" alt="Lay's Classic Chips">
                    </div>

                    <!-- 4. Right: Takis Spicy Munchies (Red/Purple Bag) -->
                    <div class="fan-product fan-product-right" title="Takis Crunchy Snacks" onclick="window.location='{{ route('catalog') }}?search=Takis';">
                        <img src="{{ asset('images/transparent/takis.png') }}" alt="Takis Spicy Snacks">
                    </div>

                    <!-- 5. Bottom Left: Kinder Bueno Chocolate Wafer Bar -->
                    <div class="fan-product fan-product-bottom-left" title="Kinder Bueno Wafer Bar" onclick="window.location='{{ route('catalog') }}?search=Bueno';">
                        <img src="{{ asset('images/transparent/kinder_bueno.png') }}" alt="Kinder Bueno">
                    </div>

                    <!-- 6. Bottom Right: Milka Choco Cookies (Purple Pouch) -->
                    <div class="fan-product fan-product-bottom-right" title="Milka Choco Cookies" onclick="window.location='{{ route('catalog') }}?search=Milka';">
                        <img src="{{ asset('images/transparent/milka_cookie.png') }}" alt="Milka Choco Cookie">
                    </div>

                    <!-- 7. Foreground Center: Pringles Original Can -->
                    <div class="fan-product fan-product-fg" title="Pringles Original" onclick="window.location='{{ route('catalog') }}?search=Pringles';">
                        <img src="{{ asset('images/transparent/pringles.png') }}" alt="Pringles Original">
                    </div>

                </div>
            </div>

        </div>

        <!-- 5 White Feature Pills Row Across the Bottom of the Hero (MindFuel Style) -->
        <div class="mindfuel-pills-row">
            <div class="mindfuel-pill-card">
                <i class="bi bi-box2-heart-fill"></i>
                <span>Crispy Snacks</span>
            </div>
            <div class="mindfuel-pill-card">
                <i class="bi bi-cup-straw"></i>
                <span>Ice-Cold Drinks</span>
            </div>
            <div class="mindfuel-pill-card">
                <i class="bi bi-flower1"></i>
                <span>Fresh Bakery</span>
            </div>
            <div class="mindfuel-pill-card">
                <i class="bi bi-egg-fried"></i>
                <span>Daily Dairy</span>
            </div>
            <div class="mindfuel-pill-card">
                <i class="bi bi-lightning-charge-fill"></i>
                <span>30-Min Delivery</span>
            </div>
        </div>
    </div>

    <!-- 2. Overlapping White Value Strip (MindFuel Style) -->
    <div class="mindfuel-overlap-strip">
        <div class="row align-items-center g-4">
            <div class="col-lg-3 border-lg-end">
                <div class="overlap-title">
                    Real Brands.<br>
                    <span style="color: #ca8a04;">No Waiting.</span>
                </div>
                <div class="overlap-title-sub mt-1">Direct from your local mini mart</div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="overlap-feature-item">
                    <div class="overlap-icon">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                    <div>
                        <div class="overlap-feat-title">100% Authentic Brands</div>
                        <p class="overlap-feat-desc">Lay's, Oreo, KitKat, Coca-Cola & favorites you love.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="overlap-feature-item">
                    <div class="overlap-icon">
                        <i class="bi bi-snow"></i>
                    </div>
                    <div>
                        <div class="overlap-feat-title">Ice-Cold & Fresh</div>
                        <p class="overlap-feat-desc">Sodas, energy drinks & treats packed cold to your door.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="overlap-feature-item">
                    <div class="overlap-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div>
                        <div class="overlap-feat-title">Open 7 Days</div>
                        <p class="overlap-feat-desc">7:00 AM – 11:00 PM ready whenever cravings hit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. "Shop by Mini Mart Aisle" Section (7-Column Balanced Grid) -->
    <div class="mb-4 pb-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-headline mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-grid-fill text-warning"></i>
                <span>Shop by Mini Mart Aisle</span>
            </h2>
            <a href="{{ route('catalog') }}" class="text-dark text-decoration-none fw-bold small d-flex align-items-center gap-1">
                <span>View All Aisles</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @php
            // Curated clean mini mart aisle names and authentic studio photography cutouts
            $catMeta = [
                'Snacks'        => ['label' => 'Snacks & Munchies',  'img' => asset('images/cat_snacks.jpg')],
                'Drinks'        => ['label' => 'Beverages & Sodas',  'img' => asset('images/cat_beverages.jpg')],
                'Bakery'        => ['label' => 'Bakery & Sweets',    'img' => asset('images/bakery/croissant.jpg')],
                'Milk & Dairy'  => ['label' => 'Dairy & Fresh Milk', 'img' => asset('images/cat_dairy_eggs.jpg')],
                'Fruit'         => ['label' => 'Grab & Go Fruits',   'img' => asset('images/cat_fruits_veg.jpg')],
                'Personal Care' => ['label' => 'Daily Essentials',   'img' => asset('images/personal care/Dove-Body-Wash-Coconut.jpg')],
                'Skincare'      => ['label' => 'Skincare & Care',    'img' => asset('images/skincare/Beauty-of-Joseon-Dynasty-Cream.jpg')],
            ];
        @endphp

        <!-- Single Balanced 7-Column Grid -->
        <div class="real-cat-grid">
            @foreach($categories as $category)
                @php
                    $meta = $catMeta[$category->name] ?? [
                        'label' => $category->name, 
                        'img'   => asset('images/cat_snacks.jpg')
                    ];
                @endphp
                <a href="{{ route('catalog', ['category' => $category->CatID]) }}" class="real-cat-card">
                    <div class="real-cat-img-box">
                        <img src="{{ $meta['img'] }}" alt="{{ $category->name }}">
                    </div>
                    <div>
                        <div class="real-cat-title">{{ $meta['label'] }}</div>
                        <div class="real-cat-count">{{ $category->products_count }} items</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- 4. Dual MindFuel Style Promotional Banners (Sleek 230px Height) -->
    <div class="row g-3 promo-banner-row">
        
        <!-- Banner 1: Crave-Worthy Mart Saver (~65% width) -->
        <div class="col-lg-8">
            <div class="promo-card-saver">
                <!-- Text Content -->
                <div class="promo-saver-content">
                    <div class="promo-discount-badge-pill">
                        <i class="bi bi-tag-fill"></i>
                        <span>MINI MART SPECIAL</span>
                    </div>
                    <h2 class="promo-saver-title">
                        Weekend<br>
                        <span style="color: #facc15;">Mart Super Saver</span>
                    </h2>
                    <p class="promo-saver-desc">
                        Save up to 30% on cold drinks, crispy chips, chocolates, sweets, and everyday mart favorites. Stock up this weekend!
                    </p>
                    <a href="{{ route('catalog') }}?sort=price_low" class="btn-promo-yellow-pill">
                        <span>Shop Deals</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <!-- Smoothly Blended Edge-to-Edge Visual -->
                <img src="{{ asset('images/harvest_super_saver.jpg') }}" alt="Mini Mart Fresh Treats" class="promo-saver-image">
            </div>
        </div>

        <!-- Banner 2: Express 30-Min Delivery (~35% width) -->
        <div class="col-lg-4">
            <div class="promo-card-express">
                <!-- Text Content -->
                <div class="promo-express-content">
                    <h2 class="promo-express-title">
                        Need It Quick?<br>
                        <span style="color: #0f172a;">30-Min Delivery!</span>
                    </h2>
                    <p class="promo-express-desc">
                        Chilled sodas, sweet snacks, and late-night cravings at your doorstep in minutes.
                    </p>
                    <a href="{{ route('catalog') }}" class="btn-promo-black-pill">
                        <span>Order Now</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <!-- Delivery Scooter Rider Graphic Anchored to Bottom Right -->
                <img src="{{ asset('images/delivery_rider.jpg') }}" alt="Express Delivery Courier" class="promo-express-rider-img">
            </div>
        </div>

    </div>

    <!-- 5. "Today's Mini Mart Deals" Showcase (6 Iconic Staple Items) -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-headline mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-fire text-danger"></i>
                <span>Today's Mini Mart Deals</span>
            </h2>
            <a href="{{ route('catalog') }}?sort=price_low" class="text-dark text-decoration-none fw-bold small d-flex align-items-center gap-1">
                <span>View All Deals</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @php
            $discountPills = ['15% OFF', '25% OFF', '20% OFF', '30% OFF', '15% OFF', '20% OFF'];
            $ratings = ['4.9 (142)', '4.8 (98)', '5.0 (76)', '4.9 (185)', '4.7 (210)', '4.8 (115)'];
        @endphp

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
            @foreach($dealProducts->take(6) as $index => $product)
                @php
                    $discountLabel = $discountPills[$index % count($discountPills)];
                    $discountPct = (int) filter_var($discountLabel, FILTER_SANITIZE_NUMBER_INT);
                    $originalPrice = $product->Price * (1 + ($discountPct / 100));
                @endphp
                <div class="col">
                    <div class="grocery-product-card" style="cursor: pointer;"
                         onclick="if (!event.target.closest('form') && !event.target.closest('button')) window.location='{{ route('product.detail', $product->PID) }}';">
                        
                        <!-- Discount Tag -->
                        <span class="grocery-discount-badge">{{ $discountLabel }}</span>

                        <!-- Product Image -->
                        <a href="{{ route('product.detail', $product->PID) }}" class="grocery-img-box text-decoration-none">
                            <img src="{{ $product->image_url }}" alt="{{ $product->PName }}">
                        </a>

                        <!-- Content -->
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="grocery-cat-tag">{{ $product->category->name ?? 'Mini Mart' }}</div>
                            <a href="{{ route('product.detail', $product->PID) }}" class="grocery-item-title" title="{{ $product->PName }}">
                                {{ $product->PName }}
                            </a>
                            
                            <!-- Rating -->
                            <div class="grocery-rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-muted ms-1" style="font-size: 0.68rem;">{{ $ratings[$index % count($ratings)] }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                                <div>
                                    <div class="grocery-price-current">
                                        ${{ number_format($product->Price, 2) }}
                                        <span class="grocery-price-orig">${{ number_format($originalPrice, 2) }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add', $product->PID) }}" method="POST" onclick="event.stopPropagation();">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-grocery" title="Add to Cart">
                                        <i class="bi bi-plus-lg"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 6. Popular Picks & Mini Mart Best Sellers -->
    @if(isset($popularProducts) && $popularProducts->count() > 0)
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-headline mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-star-fill text-warning"></i>
                    <span>Mini Mart Best Sellers & Everyday Essentials</span>
                </h2>
                <a href="{{ route('catalog') }}" class="text-dark text-decoration-none fw-bold small d-flex align-items-center gap-1">
                    <span>Explore Full Mart</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                @foreach($popularProducts as $product)
                    <div class="col">
                        <div class="grocery-product-card" style="cursor: pointer;" 
                             onclick="if (!event.target.closest('form') && !event.target.closest('button')) window.location='{{ route('product.detail', $product->PID) }}';">
                            <!-- Image -->
                            <a href="{{ route('product.detail', $product->PID) }}" class="grocery-img-box text-decoration-none position-relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->PName }}">
                                @if($product->isLowStock())
                                    <span class="position-absolute top-0 start-0 badge bg-warning text-dark" style="font-size: 0.68rem; font-weight: 800;">
                                        Only {{ $product->Qty }} Left
                                    </span>
                                @endif
                            </a>

                            <!-- Details -->
                            <div class="d-flex flex-column flex-grow-1">
                                <div class="grocery-cat-tag">{{ $product->category->name ?? 'Mini Mart' }}</div>
                                <a href="{{ route('product.detail', $product->PID) }}" class="grocery-item-title" title="{{ $product->PName }}">
                                    {{ $product->PName }}
                                </a>

                                <div class="grocery-rating-stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <span class="text-muted ms-1" style="font-size: 0.68rem;">5.0 (64)</span>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                                    <div class="grocery-price-current">${{ number_format($product->Price, 2) }}</div>

                                    <form action="{{ route('cart.add', $product->PID) }}" method="POST" onclick="event.stopPropagation();">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-add-grocery">
                                            <i class="bi bi-plus-lg"></i> Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 7. Mini Mart Assurance Pillars -->
    <div id="quality-pillars" class="row g-3">
        <div class="col-md-3">
            <div class="assurance-box">
                <div class="assurance-icon">
                    <i class="bi bi-shop"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1 small" style="font-weight: 800;">Neighborhood Mart</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.78rem;">Always stocked with your favorite snacks, drinks & daily brands.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="assurance-box">
                <div class="assurance-icon">
                    <i class="bi bi-snow"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1 small" style="font-weight: 800;">Chilled & Cold Packed</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.78rem;">Ice-cold sodas, dairy & chocolates delivered chilled.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="assurance-box">
                <div class="assurance-icon">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1 small" style="font-weight: 800;">30-Min Fast Dispatch</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.78rem;">Dispatched straight from your local neighborhood mini mart.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="assurance-box">
                <div class="assurance-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1 small" style="font-weight: 800;">100% Satisfaction</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.78rem;">Instant replacement or refund if any item isn't perfect.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
