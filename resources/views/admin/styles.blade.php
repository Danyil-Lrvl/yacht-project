<style>
    body { background-color: #0f3d3e; }
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #0f3d3e; }
    ::-webkit-scrollbar-thumb { background: #2b8a8c; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #06b6d4; }

    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        width: 18px;
        height: 24px;
        background: #1a6668;
        border: 1px solid #2b8a8c;
        border-radius: 9px;
        cursor: pointer;
        opacity: 0.8;
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2306b6d4' viewBox='0 0 24 24'><path d='M12 0l8 10h-16l8-10zm0 24l-8-10h16l-8 10z'/></svg>");
        background-repeat: no-repeat;
        background-position: center;
        transition: all 0.2s;
    }
    input[type="number"]::-webkit-inner-spin-button:hover {
        opacity: 1;
        background-color: #2b8a8c;
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%23ffffff' viewBox='0 0 24 24'><path d='M12 0l8 10h-16l8-10zm0 24l-8-10h16l-8 10z'/></svg>");
    }

    .flatpickr-calendar.dark,
    .flatpickr-calendar {
        width: 360px !important;
        background: #1a6668 !important;
        border: 1px solid #2b8a8c !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5) !important;
        border-radius: 1rem !important;
        color: #ffffff !important;
    }

    .flatpickr-months {
        position: relative !important;
        padding: 8px 0 !important;
        background: #1a6668 !important;
        height: 50px !important;
    }

    .flatpickr-months .flatpickr-month {
        background: transparent !important;
        height: 40px !important;
        color: #ffffff !important;
        fill: #ffffff !important;
    }

    .flatpickr-current-month {
        position: absolute !important;
        width: 100% !important;
        left: 0 !important;
        top: 6px !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 0 45px !important;
        color: #ffffff !important;
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months {
        appearance: auto !important;
        background: #1a6668 !important;
        border: none !important;
        color: #fff !important;
        font-weight: bold;
        font-size: 15px;
    }

    .flatpickr-current-month .numInputWrapper {
        width: 65px !important;
        display: inline-block !important;
        position: relative !important;
    }

    .flatpickr-current-month input.cur-year {
        font-weight: bold;
        color: #fff !important;
        font-size: 15px;
    }

    .flatpickr-prev-month, 
    .flatpickr-next-month {
        position: absolute !important;
        top: 8px !important;
        width: 35px !important;
        height: 35px !important;
        padding: 8px !important;
        z-index: 3 !important;
        cursor: pointer;
    }

    .flatpickr-prev-month { left: 10px !important; }
    .flatpickr-next-month { right: 10px !important; }

    .flatpickr-prev-month svg, 
    .flatpickr-next-month svg {
        width: 14px;
        height: 14px;
        fill: #06b6d4 !important;
    }

    .flatpickr-innerContainer, .flatpickr-days, .dayContainer {
        background: #1a6668 !important;
        width: 360px !important;
        min-width: 360px !important;
        max-width: 360px !important;
    }

    .flatpickr-days { padding: 0 10px 10px 10px !important; }
    .dayContainer { justify-content: center !important; }
    .flatpickr-weekdays { background: #1a6668 !important; padding: 0 10px !important; }
    span.flatpickr-weekday { color: #06b6d4 !important; font-weight: bold; background: #1a6668 !important; }

    .flatpickr-day {
        color: #ffffff !important;
        border-radius: 8px !important;
        max-width: 38px !important;
        height: 38px !important;
        line-height: 38px !important;
    }

    .flatpickr-day.selected {
        background: #06b6d4 !important;
        border-color: #06b6d4 !important;
        color: #0f3d3e !important;
        font-weight: bold;
    }

    .flatpickr-day:hover { background: #2b8a8c !important; }
    .flatpickr-day.today { border-color: #06b6d4 !important; }
</style>