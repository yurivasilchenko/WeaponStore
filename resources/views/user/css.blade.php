<style>
    .success-checkmark {
        display: none; /* Hide the checkmark initially */
        position: absolute;
        right: 30px;
        bottom: 30px;
        font-size: 13px;
        color: #027148;
        font-weight: 500;
    }

    .check-icon {
        width: 56px; /* 80px - 30% */
        height: 56px; /* 80px - 30% */
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #4CAF50;

        &::before {
            top: 2px; /* 3px - 30% */
            left: -1px; /* -2px - 30% */
            width: 21px; /* 30px - 30% */
            transform-origin: 100% 50%;
            border-radius: 70px 0 0 70px;
        }

        &::after {
            top: 0;
            left: 21px; /* 30px - 30% */
            width: 42px; /* 60px - 30% */
            transform-origin: 0 50%;
            border-radius: 0 70px 70px 0;
            animation: rotate-circle 4.25s ease-in;
        }

        &::before, &::after {
            content: '';
            height: 70px; /* 100px - 30% */
            position: absolute;
            background: #FFFFFF;
            transform: rotate(-45deg);
        }

        .icon-line {
            height: 3.5px; /* 5px - 30% */
            background-color: #4CAF50;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 10;

            &.line-tip {
                top: 32px; /* 46px - 30% */
                left: 9.8px; /* 14px - 30% */
                width: 17.5px; /* 25px - 30% */
                transform: rotate(45deg);
                animation: icon-line-tip 0.75s;
            }

            &.line-long {
                top: 26.6px; /* 38px - 30% */
                right: 5.6px; /* 8px - 30% */
                width: 32.9px; /* 47px - 30% */
                transform: rotate(-45deg);
                animation: icon-line-long 0.75s;
            }
        }

        .icon-circle {
            top: -2px; /* -4px - 30% */
            left: -2px; /* -4px - 30% */
            z-index: 10;
            width: 56px; /* 80px - 30% */
            height: 56px; /* 80px - 30% */
            border-radius: 50%;
            position: absolute;
            box-sizing: content-box;
            border: 4px solid rgba(76, 175, 80, .5);
        }

        .icon-fix {
            top: 5.6px; /* 8px - 30% */
            width: 3.5px; /* 5px - 30% */
            left: 18.2px; /* 26px - 30% */
            z-index: 1;
            height: 59.5px; /* 85px - 30% */
            position: absolute;
            transform: rotate(-45deg);
            background-color: #FFFFFF;
        }
    }

    @keyframes rotate-circle {
        0% {
            transform: rotate(-45deg);
        }
        5% {
            transform: rotate(-45deg);
        }
        12% {
            transform: rotate(-405deg);
        }
        100% {
            transform: rotate(-405deg);
        }
    }

    @keyframes icon-line-tip {
        0% {
            width: 0;
            left: 0.7px; /* 1px - 30% */
            top: 13.3px; /* 19px - 30% */
        }
        54% {
            width: 0;
            left: 0.7px; /* 1px - 30% */
            top: 13.3px; /* 19px - 30% */
        }
        70% {
            width: 35px; /* 50px - 30% */
            left: -5.6px; /* -8px - 30% */
            top: 25.9px; /* 37px - 30% */
        }
        84% {
            width: 11.9px; /* 17px - 30% */
            left: 14.7px; /* 21px - 30% */
            top: 33.6px; /* 48px - 30% */
        }
        100% {
            width: 17.5px; /* 25px - 30% */
            left: 9.8px; /* 14px - 30% */
            top: 31.5px; /* 45px - 30% */
        }
    }

    @keyframes icon-line-long {
        0% {
            width: 0;
            right: 32.2px; /* 46px - 30% */
            top: 37.8px; /* 54px - 30% */
        }
        65% {
            width: 0;
            right: 32.2px; /* 46px - 30% */
            top: 37.8px; /* 54px - 30% */
        }
        84% {
            width: 38.5px; /* 55px - 30% */
            right: 0px;
            top: 24.5px; /* 35px - 30% */
        }
        100% {
            width: 33px; /* 47px - 30% */
            right: 5.6px; /* 8px - 30% */
            top: 26.6px; /* 38px - 30% */
        }
    }
</style>
