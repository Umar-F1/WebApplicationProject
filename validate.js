

function validateCredentials()
{ 
    validateuserName();
    validatePassword();
} 

function validateuserName()
{
    var name = document.register.username.value;

    if (name==null || name=="")
    { 
    alert("Please enter your name"); 
    return false; 
    }
}

function validatePassword()
{
    var password = document.register.password.value;
    var confirm_password= document.register.confirm_password.value;
    var passwordFormat = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/

    if(passwordFormat.test(password) || password == confirm_password)
    {
        return true
    }
    else
    {
        alert("Please ensure that your passwords match and that it has a minimum eight characters, at least one letter, one number and one special character:")
        return false;
    }
}


function validateCheckoutEmail()
{
    var email = document.register.username.value;
    var mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    if(mailformat.test(email))
    {
        return true;
    }
    else
    {
        alert("Invalid email address.");
        return false;
    }
}    

function validateCheckoutCell()
{
    var cell = document.register.cell.value;
    var cellformat = /^(\()?\d{3}(\))?(-|\s)?\d{3}(-|\s)\d{4}$/;

    if(cellformat.test(cell))
    {
        return true;
    }
    else
    {
        alert("Invalid phone number.");
        return false;
    }
}

function validateCheckoutAddress()
{
    var address = document.checkout.address.value;

    if (address==null || address=="")
    { 
    alert("Please enter your address"); 
    return false; 
    }
}

function validateCheckoutSuburb()
{
    var suburb = document.checkout.address.value;

    if (suburb==null || suburb=="")
    { 
    alert("Please enter your suburb"); 
    return false; 
    }
}

function validateCheckoutName()
{
    var cname = document.checkout.name.value;

    if (cname==null || cname=="")
    { 
    alert("Please enter your name for delivery"); 
    return false; 
    }
}

function validateCheckout()
{
    validateCheckoutEmail();
    validateCheckoutCell();
    validateCheckoutAddress();
    validateCheckoutSuburb();
    validateCheckoutName();
}