@foreach ($competencia as $element)
	 <option value="{{ $element->com_id }}">{{ $element->com_name }}</option>
@endforeach