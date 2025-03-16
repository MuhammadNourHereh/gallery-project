import React, { useContext, useEffect, useState } from 'react'
import './style.css'
import { request } from '../../utils/remote/requests'
import UserInput from '../../components/UserInput'
import { AppContext } from '../../provider/AppProvider'

const TagsList = () => {

  const {
    navigate,
    firstName, setFirstName,
    lastName, setLastName,
    username, setUserName,
    photos, setPhotos,
    photosUpdated, setPhotosUpdated,
    tags, setTags,
    tagsUpdated, setTagsUpdated,
    login, logout
  } = useContext(AppContext)


  // tag form
  const [tagName, setTagName] = useState("")
  const [tagColor, setTagColor] = useState(0)

  useEffect(() => {
    const user = localStorage.getItem("user")
    if (user == null) {
      navigate("/login");
    }
  }, [])

  // tags gen
  const tagsGen = () => {
    const handleTagDelete = id => {
      console.log(id)
      request("delete", "delete-tag", { id });
      setTagsUpdated()
    }

    return (
      <>
        {tags.map((v) => (
          <div key={v.id}>
            <span style={{ color: `#${v.color.toString(16).padStart(6, '0')}` }}>
              {v.name}
            </span>
            <button onClick={() => handleTagDelete(v.id)}>delete</button>
            <br />
          </div>
        ))}
      </>
    );
  };
  // add tag
  const addTag = () => {
    request("post", "create-tag", { "name": tagName, "color": tagColor, "owner": username });
    setTagsUpdated()
  }
  const handleSetTagColor = (e) => {
    const hexColor = e.target.value.replace("#", ""); // Remove '#' from color
    setTagColor(parseInt(hexColor, 16)); // Convert hex to decimal
  }
  return (
    <div>
      <nav>
        <div>
          <p>{firstName}</p>
          <p>{lastName}</p>
        </div>
        <div>
          <button onClick={logout}>logout</button>
        </div>
      </nav>
      <section>
        {tagsGen()}
        <hr />
      </section>
      <section>

        <UserInput inputName="tag" setState={setTagName} />
        <input type='color' name='color' onChange={handleSetTagColor} /><br />
        <button onClick={addTag}>add tag</button>
      </section>
    </div>
  )
}

export default TagsList