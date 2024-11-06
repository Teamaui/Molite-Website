<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= UrlHelper::img("lg.png"); ?>" type="image/x-icon">
    <title>Page Not Found</title>
</head>
<style>
    h1,
    p {
        margin: 0;
    }

    body {
        display: flex;
        height: 100vh;
        justify-content: center;
        align-items: center;
        color: #098DB3;
        text-align: center;
        font-family: sans-serif;
    }

    div {
        border: 2px solid #098DB3;
        padding: .5rem;
    }

    h1 {
        font-size: 6rem;
        animation: shake 4s infinite;
    }

    p {
        font-size: 1.4rem;
        font-style: italic;
        letter-spacing: 3px;
        border-top: 2px solid #098DB3;
        padding-top: .9rem;
    }

    h1 span {
        font-size: 5.3rem;
        vertical-align: top;
    }

    @keyframes shake {
        0% {
            transform: translateX(0);
        }

        10% {
            transform: translateX(-10px);
        }

        20% {
            transform: translateX(10px);
        }

        30% {
            transform: translateX(-10px);
        }

        40% {
            transform: translateX(10px);
        }

        50% {
            transform: translateX(-5px);
        }

        60% {
            transform: translateX(5px);
        }

        70% {
            transform: translateX(-3px);
        }

        80% {
            transform: translateX(3px);
        }

        90% {
            transform: translateX(-1px);
        }

        100% {
            transform: translateX(0);
        }

    }

    /* Styling dasar untuk paragraf */
    .wave-text {
        display: inline-block;
        font-size: 15px;
        font-weight: bold;
        color: #333;
        overflow: visible;
        white-space: nowrap;
        color: #098DB3;
    }

    /* Styling untuk setiap huruf agar bisa dianimasikan */
    .wave-text span {
        display: inline-block;
        transform-origin: bottom;
        animation: wave 3s ease-in-out infinite;
    }

    /* Keyframe animasi untuk efek gelombang */
    @keyframes wave {
        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-7px);
        }

    }
</style>

<body>
    <div>
        <h1>4<span>&#8856;</span>4</h1>
        <p class="wave-text">Halaman &nbsp; Yang &nbsp; Dicari &nbsp; Tidak &nbsp; Ditemukan</p>
    </div>

    <script>
        // Ambil elemen paragraf
        const textElement = document.querySelector(".wave-text");
        const text = textElement.textContent;
        textElement.textContent = "";

        // Loop untuk membungkus setiap huruf dalam span
        text.split("").forEach((char, index) => {
            const span = document.createElement("span");
            span.textContent = char;
            span.style.animationDelay = `${index * 0.1}s`; // Jeda antar huruf
            textElement.appendChild(span);
        });
    </script>
</body>

</html>