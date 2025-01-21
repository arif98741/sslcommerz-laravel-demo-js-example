<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vite App1</title>
</head>

<body>
    <div id="app">
        <button class="your-button-class" id="sslczPayBtn" token="435435345345435n" postdata="{345345,345345,345435435}"
            order="If you already have the transaction generated for current order"
            endpoint="https://localhost/sslcommerz-popup-payment/public/process-payment"> Pay Now
        </button>
    </div>
    <!-- <script type="module" src="/src/main.js"></script> -->
    <script>
        (function(window, document) {
            const loader = () => {
                const script = document.createElement("script");
                const firstScript = document.getElementsByTagName("script")[0];
                script.src =
                    `https://sandbox.sslcommerz.com/embed.min.js?${Math.random().toString(36).substring(7)}`;
                firstScript.parentNode.insertBefore(script, firstScript);
            };

            window.addEventListener("load", loader);
        })(window, document);
    </script>
</body>

</html>
