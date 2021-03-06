    <style>
        body {
            background: #f8fafb;
        }

        .login>div {
            background: #f8fafb;
        }

        .content {
            background: white;
            margin-top: calc(50vh - 226px);
        }

        .main {
            box-shadow: 0 0 60px #15151589;
        }

        .login.alert {
            display: block !important;
            position: fixed;
            bottom: 0;
            padding: 3%;
            text-align: left;
            right: -30%;
            z-index: 10;
            min-height: 10vh;
            min-width: 20%;
            color: white;
            font-size: 18px !important;
            transition: 0.5s ease-in-out;
        }

        .login.alert-success {
            border-top: 6px solid rgb(1, 78, 1);
            background: rgb(1, 110, 1) !important;
        }

        .login.alert-danger {
            border-top: 6px solid rgb(107, 1, 1);
            background: rgb(151, 1, 1) !important;
        }

        .alert.alert-active {
            right: 0 !important;
            transition: 0.5s;
        }

        .text-gold {
            color: #d0aa3c !important;
        }

        .btn-warning {
            background-color: #d0aa3c !important;
            color: white !important;
            border-color: #d0aa3c !important;
        }

        #login {
            margin-left: calc(100% - 137px);
        }
    </style>