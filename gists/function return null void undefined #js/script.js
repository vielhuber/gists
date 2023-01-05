// the following functions are equivalent and ALWAYS return undefined
function test()
{
    return undefined;
}
function test()
{
    return;
}
function test()
{

}

// this function is different
function test()
{
    return null;
}