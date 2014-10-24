$('{{ $selector }}').fdatepicker({
	format: 'yyyy-mm-dd',
	weekStart: 1,
	language: '{{ $appLanguage->code }}'
});
