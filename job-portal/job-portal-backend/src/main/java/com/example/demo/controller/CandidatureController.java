package com.example.demo.controller;

import com.example.demo.dto.CandidatureRequest;
import com.example.demo.dto.RecruiterDTO;
import com.example.demo.model.Candidature;
import com.example.demo.model.CandidatureStatus;
import com.example.demo.model.Recruiter;
import com.example.demo.repository.RecruiterRepository;
import com.example.demo.service.CandidatureService;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.util.List;
import java.util.stream.Collectors;

@RestController
@RequestMapping("/candidatures")
@CrossOrigin(origins = "*")
public class CandidatureController {

    private final CandidatureService candidatureService;
    private final RecruiterRepository recruiterRepository;

    public CandidatureController(
            CandidatureService candidatureService,
            RecruiterRepository recruiterRepository) {
        this.candidatureService = candidatureService;
        this.recruiterRepository = recruiterRepository;
    }

    // CREATE
    @PostMapping
    public Candidature create(@RequestBody CandidatureRequest request) {
        return candidatureService.create(request);
    }

    // CREATE WITH FILE
    @PostMapping(value = "/upload", consumes = "multipart/form-data")
    public Candidature createWithFile(
            @RequestParam String poste,
            @RequestParam String message,
            @RequestParam Long recruiterId,
            @RequestParam Long candidatId,
            @RequestParam(required = false) MultipartFile file) throws Exception {

        return candidatureService.createWithFile(
                poste,
                message,
                recruiterId,
                candidatId,
                file);
    }

    // GET ALL
    @GetMapping
    public List<Candidature> getAll() {
        return candidatureService.getAll();
    }

    // GET BY ID ✅ AJOUTÉ
    @GetMapping("/{id}")
    public Candidature getById(@PathVariable Long id) {
        return candidatureService.getById(id);
    }

    // GET BY CANDIDAT
    @GetMapping("/candidat/{id}")
    public List<Candidature> getByCandidat(@PathVariable Long id) {
        return candidatureService.getByCandidat(id);
    }

    // GET BY RECRUTEUR
    @GetMapping("/recruteur/{id}")
    public List<Candidature> getByRecruiter(@PathVariable Long id) {
        return candidatureService.getByRecruiter(id);
    }

    // UPDATE STATUS
    @PutMapping("/{id}/status")
    public Candidature updateStatus(
            @PathVariable Long id,
            @RequestParam String status) {

        return candidatureService.updateStatus(
                id,
                CandidatureStatus.valueOf(status.toUpperCase()));
    }

    // GET RECRUTEURS
    @GetMapping("/recruteurs")
    public List<RecruiterDTO> getRecruteurs() {
        return recruiterRepository.findAll()
                .stream()
                .map(r -> new RecruiterDTO(
                        r.getId(),
                        r.getCompanyName()))
                .collect(Collectors.toList());
    }

    // GET RECRUITER FROM USER ID
    @GetMapping("/recruiter/by-user/{userId}")
    public Recruiter getRecruiterByUserId(
            @PathVariable Long userId) {

        return recruiterRepository.findByUserId(userId)
                .orElseThrow(() -> new RuntimeException("Recruiter not found"));
    }
}