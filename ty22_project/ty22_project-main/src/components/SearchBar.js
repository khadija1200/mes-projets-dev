import React, { useState } from "react";
import '../assets/css/search.css';

const SearchBar = ({ onSearch }) => {
  // Utilisation de useState pour gérer les valeurs des champs
  const [keyword, setKeyword] = useState("");
  const [location, setLocation] = useState("");

  const handleSearch = (e) => {
    e.preventDefault();
    // Appel de la fonction onSearch en passant les valeurs
    if (onSearch) {
      onSearch(keyword, location);
    }
  };

  return (
    <div className="search-container">
      <form onSubmit={handleSearch}>
        <div className="inner-form">
          <div className="input-field first-wrap">
            <input
              id="search"
              type="text"
              placeholder="Que recherchez vous ?"
              value={keyword}
              onChange={(e) => setKeyword(e.target.value)} // Met à jour la valeur de keyword
            />
          </div>
          <div className="input-field second-wrap">
            <input
              id="location"
              type="text"
              placeholder="Location"
              value={location}
              onChange={(e) => setLocation(e.target.value)} // Met à jour la valeur de location
            />
          </div>
          <div className="input-field third-wrap">
            <button className="btn-search" type="submit">
              rechercher
            </button>
          </div>
        </div>
      </form>
    </div>
  );
};

export default SearchBar;
