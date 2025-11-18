@php
    $wow = 0;
    $increment = 0.2;
@endphp
@foreach($admin_clubs as $key=>$admin_club)
    @php
        $wow = ($key == 6) ? 0 : $wow+$increment;
    @endphp
    {!! Theme::partial('admin_board.admin_club.item', ['admin_club' => $admin_club, 'img_slider' => true, 'wow' => $wow]) !!}
@endforeach
<style>
    .group-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 480px; /* Fixed height for all cards */
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
    }

    .group-card .card-image {
        position: relative;
        overflow: hidden;
        height: 250px; /* Fixed height for image container */
        flex-shrink: 0; /* Prevents image container from shrinking */
    }

    .group-card .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .group-card:hover .card-image img {
        transform: scale(1.05);
    }

    .group-card .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .group-card:hover .card-overlay {
        opacity: 1;
    }

    .group-card .card-content {
        padding: 1.5rem;
        flex-grow: 1; /* Allows content to fill remaining space */
        display: flex;
        flex-direction: column;
        overflow: hidden; /* Prevents content overflow */
    }

    .group-card h2 {
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
        line-height: 1.2;
        height: calc(1.25rem * 1.2 * 3); /* Exact 2 lines: font-size * line-height * number of lines */
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        word-break: break-word;
        text-overflow: ellipsis;
    }

    .group-card h2 a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .group-card h2 a:hover {
        color: #007bff;
    }

    .group-card p {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 0;
        flex-grow: 1;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Limits description to 3 lines */
        -webkit-box-orient: vertical;
    }

    .group-card .btn {
        margin-top: 1rem;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .group-card:hover .btn {
        transform: translateY(0);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .group-card {
            height: 400px;
        }

        .group-card .card-image {
            height: 200px;
        }
    }

    @media (max-width: 768px) {
        .group-card {
            height: 380px;
        }

        .group-card .card-image {
            height: 180px;
        }

        .group-card h2 {
            font-size: 1.1rem;
            height: calc(1.1rem * 1.2 * 3); /* Adjust height for smaller font size */
        }
    }
</style>
