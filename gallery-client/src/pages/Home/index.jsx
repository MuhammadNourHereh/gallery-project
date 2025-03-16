import React, { useContext, useEffect, useRef, useState } from 'react'
import './style.css'
import PhotoCard from '../../components/PhotoCard'
import { request } from '../../utils/remote/requests'
import UserInput from '../../components/UserInput'
import { fileToBase64 } from '../../utils/base64Utils'
import { AppContext } from '../../provider/AppProvider'

const Home = () => {

  const {
    navigate,
    firstName, setFirstName,
    lastName, setLastName,
    username, setUserName,
    photos, setPhotos,
    photosUpdated, setPhotosUpdated,
    tags, setTags,
    tagsUpdated, setTagsUpdated,
    login, logout,
    loginRedirectIfNeeded,
  } = useContext(AppContext)


  // photo form
  const [photoTitle, setPhotoTitle] = useState("")
  const [photoDesc, setPhotoDesc] = useState("")
  const [photoFile, setPhotoFile] = useState("")

  useEffect(() => {
    loginRedirectIfNeeded()
  }, [])

  // gen photos
  const genPhotos = () => {
    if (photos.length === 0)
      return (<p>no images to show</p>)
    else
      return (
        <>
          {photos.map(photo => (
            <PhotoCard key={photo.id}
              id={photo.id}
              url={photo.url}
              title={photo.title}
              desc={photo.desc}
              handleDeletion={() => handlePhotoDeletion(photo.id)}
              tags={tags} />
          ))}
        </>
      );
  }
  // add photo
  const uploadPhoto = async () => {

    const base64 = await fileToBase64(photoFile)
    request("post", "upload-photo", { "title": photoTitle, "desc": photoDesc, "base64": base64, "owner": username });
    setPhotosUpdated()
  }

  // delete photo
  const handlePhotoDeletion = (id) => {
    request("delete", "delete-photo", { id });
    setPhotosUpdated()
  }


  const handleSetPhotoFile = e => {
    const file = e.target.files[0]; // Get the selected file

    if (!file) {
      console.error("No file selected");
      return; // Exit if no file is selected
    }
    console.log(file)
    setPhotoFile(file)
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

      <section className='photos'>
        {genPhotos()}
      </section>
      <hr />
      <section>
        <UserInput inputName="name" setState={setPhotoTitle} />
        <UserInput inputName="desc" setState={setPhotoDesc} />
        <input type='file' onChange={handleSetPhotoFile} /><br />
        <button onClick={uploadPhoto}>upload</button>
      </section>
    </div>
  )
}

export default Home