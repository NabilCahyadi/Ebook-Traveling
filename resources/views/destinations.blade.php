@extends('layouts_lp.app')
@section('title', 'Destinations - MeatMap')

@section('content')
<style>
    /* style untuk top 10 slider */
    .slider-container {
        position: relative;
        width: 100%;
        height: 600px;
        background: #f5f5f5;
        box-shadow: 0 30px 50px #dbdbdb;
        border-radius: 20px;
        overflow: hidden;
        margin: 50px auto;
    }

    .slider-container .slide .item {
        width: 200px;
        height: 300px;
        position: absolute;
        top: 50%;
        transform: translate(0, -50%);
        border-radius: 20px;
        /* box-shadow: 0 30px 50px #8c8c8c3e; */
        background-position: 50% 50%;
        background-size: cover;
        background-repeat: no-repeat;
        display: inline-block;
        transition: .5s;
    }

    .slide .item:nth-child(1),
    .slide .item:nth-child(2) {
        top: 0;
        left: 0;
        transform: translate(0, 0);
        border-radius: 0;
        width: 100%;
        height: 100%;
    }

    .slide .item:nth-child(2) .content {
        display: block;
    }

    .slide .item:nth-child(3) {
        left: 50%;
    }

    .slide .item:nth-child(4) {
        left: calc(50% + 220px);
    }

    .slide .item:nth-child(5) {
        left: calc(50% + 440px);
    }

    .slide .item:nth-child(n + 6) {
        left: calc(50% + 440px);
        overflow: hidden;
    }

    .item .content {
        position: absolute;
        top: 50%;
        left: 100px;
        width: 400px;
        text-align: left;
        color: #eee;
        transform: translate(0, -50%);
        font-family: 'Poppins', sans-serif;
        display: none;
    }

    .content .name {
        font-size: 40px;
        text-transform: uppercase;
        font-weight: bold;
        opacity: 0;
        margin-bottom: 20px;
        animation: animate 1s ease-in-out 1 forwards;
    }

    .content .description {
        margin-top: 10px;
        margin-bottom: 20px;
        opacity: 0;
        animation: animate 1s ease-in-out .3s 1 forwards;
        font-size: 21px;
        line-height: 1.6;
        max-width: 380px;
        font-weight: 400;
    }

    .content button {
        padding: 12px 25px;
        border: none;
        cursor: pointer;
        opacity: 0;
        animation: animate 1s ease-in-out .6s 1 forwards;
        background: #FF4C61;
        color: white;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .content button:hover {
        background: #e04355;
        transform: translateY(-2px);
    }

    @keyframes animate {
        from {
            opacity: 0;
            transform: translate(0, 100px);
            filter: blur(33px);
        }

        to {
            opacity: 1;
            transform: translate(0);
            filter: blur(0);
        }
    }

    .slider-button {
        width: 100%;
        text-align: center;
        position: absolute;
        bottom: 20px;
        z-index: 10;
    }

    .slider-button button {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        margin: 0 10px;
        background: #F2F3F4;
        color: #7E7E7E;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .slider-button button:hover {
        background: #FF4C61;
        color: white;
        transform: scale(1.05);
    }

    /* Overlay untuk readability */
    .item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.1) 100%);
        border-radius: inherit;
    }

    .item .content {
        z-index: 2;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .slider-container {
            height: 500px;
            margin: 30px auto;
        }

        .item .content {
            left: 50px;
            width: 320px;
        }

        .content .name {
            font-size: 30px;
        }

        .content .description {
            font-size: 16px;
            max-width: 300px;
        }
    }

    @media (max-width: 576px) {
        .slider-container {
            height: 400px;
        }

        .item .content {
            left: 30px;
            width: 280px;
        }

        .content .name {
            font-size: 24px;
        }

        .content .description {
            font-size: 15px;
            max-width: 260px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
    }
</style>
<style>
    /* Combined Destination Cards Style */
    .destination-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(16, 24, 40, 0.06);
        margin-bottom: 1.25rem;
        transition: all 0.3s ease;
    }

    .destination-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .destination-thumb {
        height: 170px;
        background-position: center;
        background-size: cover;
        transition: transform 0.3s ease;
        border-radius: 12px 12px 0 0;
    }

    .destination-card:hover .destination-thumb {
        transform: scale(1.05);
    }

    .destination-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #FF4C61;
        color: #fff;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 6px 18px rgba(255, 76, 97, 0.18);
        z-index: 2;
    }

    .destination-content {
        padding: 12px 14px 16px;
    }

    .destination-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 6px;
        color: #0f172a;
    }

    .destination-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .destination-stars {
        color: #FFB74D;
    }

    .destination-stars i {
        color: #FFB74D;
        margin-right: 2px;
    }

    .destination-rating {
        font-weight: 600;
        color: #111827;
        margin-left: 6px;
    }

    @media(min-width:1200px) {
        .col-xl-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    }
</style>

<!-- top 10 city slider -->
<div class="container">
    <div class="slider-container">
        <div class="slide">
            <div class="item" style="background-image: url('https://media.istockphoto.com/id/675172642/id/foto/pura-ulun-danu-bratan-temple-in-bali.jpg?s=1024x1024&w=is&k=20&c=KHoO6z4Ieb321gAxNg-E3qVYWhEsXHbS5-Unbt6Tggo=');">
                <div class="content">
                    <div class="name">Denpasar</div>
                    <div class="description">The capital of Bali, blending modern commerce with deep Hindu cultural traditions and temples.</div>
                </div>
            </div>

            <div class="item" style="background-image: url('https://cdn.pixabay.com/photo/2023/04/09/17/24/cukul-7911922_1280.jpg');">
                <div class="content">
                    <div class="name">Bandung</div>
                    <div class="description">The 'Paris van Java,' famed for its vibrant fashion districts and cool, mountainous air.</div>
                </div>
            </div>

            <div class="item" style="background-image: url('https://media.istockphoto.com/id/181928587/id/foto/pemandangan-udara-puncak-gunung-di-kabut.jpg?s=1024x1024&w=is&k=20&c=sQITAR0_0Ip57_wJ5qiB7ucTQybvX2z4rgiYGOnQ82k=');">
                <div class="content">
                    <div class="name">Surabaya</div>
                    <div class="description">The City of Heroes, a bustling commercial hub with rich historical monuments and modern architecture.</div>
                </div>
            </div>

            <div class="item" style="background-image: url('https://cdn.pixabay.com/photo/2018/02/04/15/04/water-3130017_1280.jpg');">
                <div class="content">
                    <div class="name">Semarang</div>
                    <div class="description">A coastal city renowned for its iconic blend of Javanese, Chinese, and colonial history.</div>
                </div>
            </div>

            <div class="item" style="background-image: url('https://media.istockphoto.com/id/500798563/id/foto/city-skyline-at-sunset-jakarta-indonesia.jpg?s=1024x1024&w=is&k=20&c=0cNJTIZnHd8gDyJsWSCrY5xWBUcb0rbgF7eA9qgq3Tc=');">
                <div class="content">
                    <div class="name">Jakarta</div>
                    <div class="description">The dynamic capital, offering everything from towering skyscrapers to cultural heritage sites like Kota Tua.</div>
                </div>
            </div>

            <div class="item" style="background-image: url('https://cdn.pixabay.com/photo/2023/07/12/18/21/croatia-8123037_1280.jpg');">
                <div class="content">
                    <div class="name">Serang</div>
                    <div class="description">Gateway to historical Banten, featuring fascinating ruins and stunning proximity to the coast.</div>
                </div>
            </div>

            <div class="item" style="background-image: url('https://cdn.pixabay.com/photo/2017/05/18/17/03/view-2324147_1280.jpg');">
                <div class="content">
                    <div class="name">Medan</div>
                    <div class="description">A vibrant culinary capital in Sumatra, known for its strong Batak culture and colonial palaces.</div>
                </div>
            </div>

            <div class="item" style="background-image: url('https://cdn.pixabay.com/photo/2022/04/15/07/58/sunset-7133867_1280.jpg');">
                <div class="content">
                    <div class="name">Makassar</div>
                    <div class="description">The bustling port city of Sulawesi, famous for its fresh seafood and the historic Fort Rotterdam.</div>
                </div>
            </div>

            <div class="item" style="background-image: url('https://cdn.pixabay.com/photo/2020/12/28/20/43/prambanan-5868468_1280.jpg');">
                <div class="content">
                    <div class="name">Yogyakarta</div>
                    <div class="description">Indonesia's cultural heart, the center of Javanese arts, traditional crafts, and royal history.</div>
                </div>
            </div>

            <div class="item" style="background-image: url('https://media.istockphoto.com/id/2170318407/id/foto/pemandangan-indah-pulau-pahawang-kecil.jpg?s=1024x1024&w=is&k=20&c=ySuWUZ6QGongHncmTxos0xMxZLbcvm4oKRviki63odA=');">
                <div class="content">
                    <div class="name lh-sm">Bandar Lampung</div>
                    <div class="description">The gateway to Sumatra's nature, providing access to elephant preserves and scenic beaches.</div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="slider-button">
            <button class="prev"><i class="bi bi-chevron-left"></i></button>
            <button class="next"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</div>

<!-- cards -->
<section class="destinations-cards py-5">
    <div class="container">
        <div class="text-center mb-10">
            <h3 class="mb-4">Destinations Across Indonesia</h3>
            <p class="mb-4 mx-auto" style="max-width:50rem;">
                Explore diverse destinations from beaches to cities — discover hidden gems and popular spots with authentic local experiences.
            </p>
        </div>
        <div class="row">
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2017/08/09/12/05/piaynemo-2614341_1280.jpg');"></div>
                    <span class="destination-badge">#1</span>
                    <div class="destination-content">
                        <div class="destination-title">Raja Ampat Islands</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.5</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2016/01/08/06/57/komodo-1127251_1280.jpg');"></div>
                    <span class="destination-badge">#2</span>
                    <div class="destination-content">
                        <div class="destination-title">Komodo National Park</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                            </div>
                            <div class="destination-rating">4.7</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2022/01/20/07/06/mount-bromo-6951610_1280.jpg');"></div>
                    <span class="destination-badge">#3</span>
                    <div class="destination-content">
                        <div class="destination-title">Mount Bromo</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.4</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4-20 (Tanpa badge) -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2022/02/27/08/55/sea-7036882_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Lake Toba</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.1</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2020/04/29/12/21/island-5108695_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Gili Islands</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <div class="destination-rating">5.0</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2020/12/28/20/43/prambanan-5868468_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Prambanan Temple</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                            </div>
                            <div class="destination-rating">4.6</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2017/09/08/21/26/rice-2730253_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Ubud Rice Terraces</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.3</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2023/04/09/17/24/cukul-7911922_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Bandung Highlands</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.0</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2022/04/15/07/58/sunset-7133867_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Fort Rotterdam</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">3.8</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2018/02/04/15/04/water-3130017_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Semarang Old Town</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.2</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2020/02/13/09/50/jakarta-4845108_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Jakarta Monas</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">3.7</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2017/06/02/12/14/temple-2366184_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Borobudur Temple</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                            </div>
                            <div class="destination-rating">4.8</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2020/06/27/15/24/beach-5346210_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Bali Beaches</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.4</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2017/03/14/10/45/detian-waterfall-2142636_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Sewu Waterfall</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.5</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.pixabay.com/photo/2020/10/01/08/06/field-5617818_1280.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Rinjani Volcano</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                            </div>
                            <div class="destination-rating">4.7</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://res.cloudinary.com/enchanting/image/upload/v1/artemis-mdm/places/c693afb6-f379-4b43-9ccf-e3163a9fea04.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Toraja Highlands</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.3</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://encrypted-tbn0.gstatic.com/licensed-image?q=tbn:ANd9GcR3emKyKwXpQYA4-Laj6qDURmejY3BzLgCLl9iIPZXO1RUyWUzmXK3r3b7zwK6obMXcvTPuUI_olnIlLPPpNjavlSZs&s=19');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Derawan Islands</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                            </div>
                            <div class="destination-rating">4.6</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://www.wakatobi.com/wp-content/uploads/2024/01/2023_wakatobi_aerial.webp');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Wakatobi Diving</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <div class="destination-rating">5.0</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="destination-card position-relative">
                    <div class="destination-thumb" style="background-image:url('https://cdn.audleytravel.com/6755/4820/79/1337066-bunaken-marine-park.jpg');"></div>
                    <div class="destination-content">
                        <div class="destination-title">Bunaken Marine Park</div>
                        <div class="destination-meta">
                            <div class="destination-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                            </div>
                            <div class="destination-rating">4.7</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let next = document.querySelector('.next');
        let prev = document.querySelector('.prev');

        next.addEventListener('click', function() {
            let items = document.querySelectorAll('.item');
            document.querySelector('.slide').appendChild(items[0]);
        })

        prev.addEventListener('click', function() {
            let items = document.querySelectorAll('.item');
            document.querySelector('.slide').prepend(items[items.length - 1]);
        })
    });
</script>
@endsection