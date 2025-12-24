let hard_exceptions = ['Company name<sup>®</sup>', 'Anotherhardexception'];

document.addEventListener('DOMContentLoaded', function()
{
    exceptions.forEach(function(exceptions__value)
    {
        document.querySelector('.container').innerHTML = document.querySelector('.container').innerHTML.replace(new RegExp(exceptions__value, 'g'), '<span class="no-hyphens">'+exceptions__value+'</span>');
    });
});