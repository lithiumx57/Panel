@foreach($messages as $message)
  @if($message->type=="admin")
    <div>
      @if($message->parent>0)
      @endif
      <span id="message_{{$message->id}}" data-id="{{$message->id}}" class="user-message">{{$message->text}}</span>
    </div>
  @else
    @if($message->parent>0)
      <div class="replyMessage">
        <?php
        $parent = $message->getParent();
        if ($parent) {
          $text = $parent->text;
          $name = $parent->message->name;
          $parentText = $name . " : ";
          $parentText .= (strlen($text) > 20) ? substr($text, 0, 20) : $text;;

        } else {
          $text = " پیام حذف شده ";
          $name = "";
          $parentText = $name . " : " . strlen($text) > 20 ? substr($text, 0, 20) : $text;
        }

        ?>
        <span class="userReply">{{$parentText}}</span>
        <span id="message_{{$message->id}}" data-id="{{$message->id}}" class="admin-message">
              {{$message->text}}
            </span>
      </div>
    @else
      <div>
        <span id="message_{{$message->id}}" data-id="{{$message->id}}" class="admin-message">{{$message->text}}</span>
      </div>
    @endif
  @endif
  <div class="clearfix"></div>
  <div class="mt5"></div>
@endforeach
