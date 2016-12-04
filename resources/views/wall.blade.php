<div class="row" id="twitterContainer" data-has-tweets="{{ $hasTweets }}">
    @foreach($tweets as $tweet)
    <div class="tweet" data-id="{{ $tweet->twitterId }}">{{ $tweet->displayText }}</div>
    @endforeach
</div>
