$(document).ready(function(){
    Flatpickr.l10n.months.longhand = ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
    Flatpickr.l10n.weekdays.shorthand = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];
    document.getElementById("date_of_birth").flatpickr({
        maxDate: new Date(),
    });
});
