function change_location (item, url) {
	var Index = item.options[item.selectedIndex].value;
	location.href= url + Index;
}
