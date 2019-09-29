var somethingHasChanged = false;

window.onbeforeunload = () => {
	if(somethingHasChanged)
    {
		return 'Sind Sie sicher?';
	}
    else
    {
		return;
	}
};

document.querySelector('.selector').addEventListener('input', (e) =>
{
	somethingHasChanged = true;
});