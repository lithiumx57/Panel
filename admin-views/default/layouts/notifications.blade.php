@if(isMainStore())
  <style>
    .notification {
      width: 350px;
      height: 100px;
      transition: .3s;
      background: #ffff;
      box-shadow: 0 0 6px 0 #666;
      position: absolute;
      bottom: 20px;
      z-index: 999;
      left: 20px;
      border-radius: 4px;
    }

    .closeNotification {
      color: #0c1522;
      position: absolute;
      top: 2px;
      left: 2px;
      cursor: pointer;
    }

  </style>
  <div id="nContainer">
  </div>
  <div id="sound"></div>
  <script>

    const pusher = new Pusher("ebf3b796a612e13e67c4", {
      cluster: "us2",
      forceTLS: true
    })
    var channel = pusher.subscribe("admin_channel_product")
    channel.bind('request_product', (data) => {
      createNotification(data, "request")
    })

    channel.bind('create_product', (data) => {
      createNotification(data, "create")
    })


    var tag = document.getElementById("productRequest")

    function createNotification(data, type) {
      var nCount = parseInt(tag.innerText)
      tag.innerText = ++nCount + ""
      playNotification()
      var message = "";
      if (type === "create") {
        message = "فروشگاه " +
          "<span style='font-weight: bold;color: #f44'>" + data.store.name + "</span>" +
          " محصول  " + data.product.title + "را ثبت کرده است ";
      } else if (type === "request") {
        message = "فروشگاه " +
          "<span style='font-weight: bold;color: #f44'>" + data.store.name + "</span>" +
          " محصول  " + data.product.title + " را درخواست کرده است ";
      }


      var count = document.getElementsByClassName("notification").length
      var bottom = count * 110 + 20;
      var div = document.createElement("div")
      div.classList.add("notification")
      div.id = "notification_" + count
      div.style.bottom = bottom + "px"
      var span = document.createElement("span")
      span.classList.add("fa")
      span.classList.add("fa-close")
      span.classList.add("closeNotification")
      span.addEventListener("click", function () {
        removeNotification(div)
      })

      var messageTag = document.createElement("div")
      messageTag.style.color = "#222"
      messageTag.style.padding = "8px"
      messageTag.style.textAlign = "justify"
      messageTag.innerHTML = message
      div.appendChild(span)
      div.appendChild(messageTag)
      var container = document.getElementById("nContainer")
      container.appendChild(div)
      setTimeout(function () {
        removeNotification(div)
      }, 10000)
    }

    function playNotification() {
      var filename = "/files/app/notification.mp3"
      let audio = new Audio(filename);
      try {
        audio.play().then().catch();
      } catch (e) {
      }
    }

    function removeNotification(div) {
      var current = parseInt((div.id).replace("notification_", ""))
      var notifications = document.getElementsByClassName("notification")
      for (let i = 0; i < notifications.length; i++) {
        var notification = notifications[i]
        var id = parseInt(notification.id.replace("notification_", ""))

        if (id > current) {
          var bottom = parseInt((notification.style.bottom).replace("px", "")) - 110;
          notification.style.bottom = bottom + "px";
        }
      }
      $(div).remove()
    }
  </script>
@endif