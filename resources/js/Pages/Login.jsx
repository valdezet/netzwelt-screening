import React from 'react'


export default function Login() {
    return <div className='centered-page-wrapper'>
        <div>
            <form className='login-form'>
                <label className='form-element'>
                    Username
                    <input  className='form-element' type="text" name="username"/>
                </label>

                <label className='form-element'>
                    Password
                    <input  className='form-element' type="password" name="password"/>
                </label>

                <div className='right-element-wrapper form-element'>
                    <input type="submit" value="Log in" />
                </div>
            </form>
        </div>
    </div>
}
