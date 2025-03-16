import React from 'react'
import './style.css'

const Tag = ({ name, color, handleDetachTag }) => {
    return (
        <div className='tag'
            style={{ backgroundColor: color }}
            onClick={handleDetachTag}>
            {name}
        </div>
    )
}

export default Tag