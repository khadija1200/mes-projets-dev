package com.example.demo.dto;

import lombok.Data;

@Data
public class CandidatureRequest {

    private String poste;
    private String message;
    private Long recruiterId;
    private Long candidatId;
}