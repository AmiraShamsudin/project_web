<footer class="footer">
<section class="grid">
    <div class="box">
            <div class="credit">
                <h1>&copy; <?php echo date("Y"); ?> Amira Shamsudin | All rights reserved.</h1>
            </div>
            <div class="box">
                <h3><a href="https://www.google.com">Privacy Policy</a></h3>
            </div>
            <div class="box">
                <h3><a href="https://www.google.com">Terms of Service</a></h3>
            </div>
            <div class="box">
                <h3><a href="https://www.google.com">Contact Us</a></h3>
            </div>
    </div>
</section>
</footer>

<style>
    .footer {
        background-color: #f8f9fa;
        padding: 150px;
    }
    .grid {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }
    .box {
        flex: 1;
        min-width: 250px;
        margin: 10px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        text-align: center;
    }
    .box h3 a {
        text-decoration: none;
        color: #333;
    }
    .box h3 a:hover {
        color: #007bff;
    }
</style>