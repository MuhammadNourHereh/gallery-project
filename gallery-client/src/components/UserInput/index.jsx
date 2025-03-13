import React from 'react'
import './style.css'

const UserInput = ({ inputName }) => {
    return (
        <div className='flex-column'>
            <label className='' for={inputName}>{inputName}:</label>
            <input id={inputName} className='' name={inputName} placeholder={inputName} />
        </div>
    )
}

export default UserInput
