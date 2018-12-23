$(function () {
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    });
    $(".btn-experience").on("click", function () {
      location.href = "/api/pay/pay_order?order_id=21&type=" + $(this).data("type") + "&platform=" + $("#method").val();
      //   location.href = "/addons/epay/index/experience?amount=" + $("input[name=amount]").val() + "&type=" + $(this).data("type") + "&method=" + $("#method").val();
    });

});