<a data-fancybox data-type="ajax" data-src="{{ route('simple-slider-item.edit', $item->id) }}" href="javascript:;"
   class="btn btn-info"><i class="fa fa-edit"></i> {{ trans('kamruldashboard::tables.edit') }}</a>
<a data-fancybox data-type="ajax" data-src="{{ route('simple-slider-item.destroy', $item->id) }}" href="javascript:;"
   class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('kamruldashboard::tables.delete_entry') }}</a>
