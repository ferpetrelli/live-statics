<div id="statics-controls">
  <form action="">
    @foreach (DynamicManager::parametersByType() as $type => $fields)
      @switch($type)
        @case('sentence')
          @foreach ($fields as $field)
            <div class="static-element-container">
              <p>{{ $field->name() }} (Number of words): <span data-name="{{ $field->parameterName() }}">{{ $field->value() }}</span></p>
              <input data-input type="range" min="{{ $field->edgeValues()['min'] }}" max="{{ $field->edgeValues()['max'] }}" value="{{ $field->value() }}" class="slider" name="{{ $field->parameterName() }}">
            </div>
          @endforeach
          @break
        @case('text')
          @foreach ($fields as $field)
            <div class="static-element-container">
              <p>{{ $field->name() }} (Number of characters): <span data-name="{{ $field->parameterName() }}">{{ $field->value() }}</span></p>
              <input data-input type="range" min="{{ $field->edgeValues()['min'] }}" max="{{ $field->edgeValues()['max'] }}" value="{{ $field->value() }}" class="slider" name="{{ $field->parameterName() }}">
            </div>
          @endforeach
          @break
      @endswitch
    @endforeach

    <input id="static-submit" type="submit" />

  </form>
</div>


{{-- Fixed position button to toggle menu --}}
<span class="design-grid-toggle design-grid-toggle--statics" onClick="document.getElementById('statics-controls').classList.toggle('statics-controls-visible');" title="Toggle Statics Controls">
  <svg enable-background="new 0 0 10 10" version="1.1" viewBox="0 0 10 10" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
    <rect fill="currentColor" width="10" height="1"/>
    <rect fill="currentColor" y="3" width="10" height="1"/>
    <rect fill="currentColor" y="6" width="10" height="1"/>
    <rect fill="currentColor" y="9" width="10" height="1"/>
    <polygon fill="currentColor" points="8,8 2,8 3.5,3 5.5,6.2 6.5,5.2 "/>
    <path fill="currentColor" d="M9,1v8H1V1H9 M10,0H0v10h10V0L10,0z"/>
  </svg>
</span>


{{-- Style definitions for the menu --}}

<style>

.design-grid-toggle--statics {
  position: fixed;
  z-index: 1000;
  width: 25px;
  height: 25px;
  right: 30px;
  bottom: 30px;
}

#statics-controls {
  display: none;
  position: fixed; /* Sit on top of the page content */
  width: 500px; /* Full width (cover the whole page) */
  right: 0;
  bottom: 100px;
  background-color: rgb(0,0,0); /* Black background with opacity */
  z-index: 10000; /* Specify a stack order in case you're using a different order for other elements */
  color: white;
  font-size: small;
}

#statics-controls.statics-controls-visible {
  display: block;
}


.static-element-container {
    padding-left: 10px;
    padding-right: 10px;
}

.static-element-container p {
  margin-left: 2px;
}


#static-submit {
    margin-left: 10px;
    padding: 10px;
    margin-top: 20px;
}

/* The slider itself */
.slider {
    -webkit-appearance: none;  /* Override default CSS styles */
    appearance: none;
    width: 100%; /* Full-width */
    height: 5px; /* Specified height */
    outline: none; /* Remove outline */
    opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
    -webkit-transition: .2s; /* 0.2 seconds transition on hover */
    transition: opacity .2s;
    border-radius: 5px;
}

/* Mouse-over effects */
.slider:hover {
    opacity: 1; /* Fully shown on mouse-over */
}

/* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
.slider::-webkit-slider-thumb {
    -webkit-appearance: none; /* Override default look */
    appearance: none;
    width: 15px; /* Set a specific slider handle width */
    height: 15px; /* Slider handle height */
    border-radius: 50%;
    background: #83ff6d; /* Green background */
    cursor: pointer; /* Cursor on hover */
}

.slider::-moz-range-thumb {
    width: 15px; /* Set a specific slider handle width */
    height: 15px;
    border-radius: 50%;
    background: #83ff6d; /* Green background */
    cursor: pointer; /* Cursor on hover */
}

</style>



{{-- Javascript in charge of showing/hiding elements, as well as managing the handles --}}

<script>

  function _handleSliderValue(e) {
    document.querySelector('[data-name="' + e.target.name + '"]').innerHTML = e.target.value;
  }

  let sliders = document.querySelectorAll('input.slider');
  var urlParams = new URLSearchParams(window.location.search);

  // Init sliders
  var arrLength = sliders.length;

  for (var i = 0; i < arrLength; i++) {
    var value = urlParams.get(sliders[i].name);

    if (value) {
      sliders[i].value = value;

      document.querySelector('[data-name="' + sliders[i].name + '"]').innerHTML = value;
    }
  }

  for (var i = 0; i < arrLength; i++) {
    sliders[i].addEventListener('input', _handleSliderValue, false);
  }

</script>
