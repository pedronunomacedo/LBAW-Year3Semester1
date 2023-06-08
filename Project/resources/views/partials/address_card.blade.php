<div class="form-check address_card" style="height: auto">
    <input class="form-check-input" type="radio" value="{{$address->id}}" name="flexRadioDefault" id="flexRadioAddress{{$address->id}}">
    <label class="form-check-label d-block" for="flexRadioAddress{{$address->id}}">
        <p><strong>Street: </strong>{{$address->street}}<p>
        <p><strong>City: </strong>{{$address->city}}, {{$address->country}}</p>
        <p><strong>Postal Code: </strong>{{$address->postalcode}}</p>
    </label>
</div>
