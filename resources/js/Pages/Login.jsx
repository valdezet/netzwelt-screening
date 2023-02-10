import React from 'react'
import { router } from '@inertiajs/react';

export default function Login({errors}) {

    let submitHandler = (e) => {
        e.preventDefault();
        let formData = new FormData(e.target);
        router.post("/account/login", formData);
    }

    return <div className='centered-page-wrapper'>
        <div className='login-form'>
            {errors.error_message? <>
                <div class="error-box">
                    <p>{errors.error_message}</p>
                </div>
            </> : <></>}
            <form  onSubmit={submitHandler} >
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
