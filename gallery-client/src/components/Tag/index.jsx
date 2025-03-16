import React from 'react'
import './style.css'

const Tag = ({ name, color, handleTagDelete }) => {
    return (
        <div className='tag'
            style={{ backgroundColor: color }}
            onClick={handleTagDelete}>
            {name}
        </div>
    )
}

export default Tag