@extends('layout.admin')

@section('content')
  <h3>
    <a href="{{ action('CarController@listItem') }}">Item</a>
    | #{{ $item->id }}
    | Edit
  </h3>
    <div class="row">
    {!!
      Form::open([
        'role' => 'form',
        'url' => action('CarController@updateItem', ['id' => $item->id]),
        'method' => 'post',
      ])
    !!}

    @include('form.text', [
      'field' => 'plate_number',
      'label' => 'Plate Number',
      'placeholder' => 'plate number',
      'default' => old('plate_number', $item->plate_number),
    ])

    @include('form.select', [
      'field' => 'carmodel_id',
      'label' => 'Model',
      'options' => App\Carmodel::all()->map(function($val) {
        $val->_full_name = "{$val->brand} {$val->model} {$val->transmission} {$val->fuel}";
        return $val;
      })->pluck("_full_name", "id"),
      'default' => old('carmodel_id', $item->carmodel_id),
    ])

    <div class="form-group">
      <label class="control-label">
        Harga
      </label>
      <div class="container">
      @foreach(App\Destination::all() as $destination)
        @include('form.text', [ 
          'field' => 'prices[' . $destination->id . ']',
          'label' => $destination->name,
          'default' => $item->priceTo($destination->id)->price,
        ])
      @endforeach
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    {!!
      Form::close()
    !!}
  </div>
@endsection