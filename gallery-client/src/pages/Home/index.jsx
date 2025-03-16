import React, { useEffect, useRef, useState } from 'react'
import './style.css'
import PhotoCard from '../../components/PhotoCard'
import { useNavigate } from "react-router"
import { request } from '../../utils/remote/requests'
import UserInput from '../../components/UserInput'
import { fileToBase64 } from '../../utils/base64Utils'

const Home = () => {

  // navigate
  const navigate = useNavigate()

  // user
  const [firstName, setFirstName] = useState("firstname")
  const [lastName, setLastName] = useState("lastname")
  const [username, setUserName] = useState("username")

  // photos
  const [photos, setPhotos] = useState([])
  const [photosUpdated, setPhotosUpdated] = useState(false)

  // tags
  const [tags, setTags] = useState([{ "id": 1, "name": "a", color: 0 }]);
  const [tagsUpdated, setTagsUpdated] = useState(false);

  // tag form
  const [tagName, setTagName] = useState("")
  const [tagColor, setTagColor] = useState(0)

  // photo form
  const [photoTitle, setPhotoTitle] = useState("")
  const [photoDesc, setPhotoDesc] = useState("")
  const [photoFile, setPhotoFile] = useState("")

  useEffect(() => {
    const user = localStorage.getItem("user")
    if (user == null) {
      navigate("/login");
    } else {
      const parsedUser = JSON.parse(user);
      setFirstName(parsedUser.first_name);
      setLastName(parsedUser.last_name);
      setUserName(parsedUser.username)

      setTagsUpdated(prev => !prev)
      setPhotosUpdated(prev => !prev)
    }
  }, [navigate])

  const logout = () => {
    console.log("logout")
    localStorage.removeItem("user")
    navigate("/login");
  }





  // gen photos
  const genPhotos = () => {
    useEffect(() => {
      const a = async () => {
        try {
          const res = await request("post", "get-photos", { owner: username });
          console.log(res);
          setPhotos(res); // Ensure res.data is an array
        } catch (error) {
          setPhotos([])
        }
      }
      a()
    }, [photosUpdated])


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
    setPhotosUpdated(prev => !prev)
  }

  // delete photo
  const handlePhotoDeletion = (id) => {
    request("delete", "delete-photo", { id });
    setPhotosUpdated(prev => !prev)
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


  // tags gen
  const tagsGen = () => {
    useEffect(() => {
      const a = async () => {
        try {
          const res = await request("post", "get-tags", { owner: username });
          console.log(res);
          setTags(res); // Ensure res.data is an array
        } catch (error) {
          console.error("Error fetching tags:", error);
        }
      }
      a()
    }, [tagsUpdated]);
    const handleTagDelete = id => {
      console.log(id)
      request("delete", "delete-tag", { id });
      setTagsUpdated(prev => !prev)
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
    setTagsUpdated(prev => !prev)
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

      <section className='photos'>
        {genPhotos()}
      </section>
      <hr />
      <section>
        <UserInput inputName="name" setState={setPhotoTitle} />
        <UserInput inputName="desc" setState={setPhotoDesc} />
        <input type='file' onChange={handleSetPhotoFile} /><br />
        <button onClick={uploadPhoto}>upload</button>
        <hr /><br />
      </section>
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

export default Home